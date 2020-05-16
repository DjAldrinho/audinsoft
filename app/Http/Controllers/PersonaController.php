<?php

namespace App\Http\Controllers;

use App\Baneado;
use App\Mail\ContactEmail;
use App\Notifications\UserEstado;
use App\Reserva;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class PersonaController extends Controller
{

    /**
     * PersonaController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['busqueda', 'escuelas', 'dependencias']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::orderBy('nombre')->paginate(25);

        return view('usuarios.index', compact('usuarios'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        $user = User::find(Crypt::decrypt($user));

        $reservas = Reserva::byUsuario($user->id)->orderByDesc('created_at')->limit(5)->get();

        return view('usuarios.perfil', compact('user', 'reservas'));
    }

    public function perfil(Request $request)
    {

        $user = $request->user();

        $reservas = Reserva::byUsuario($user->id)->orderByDesc('created_at')->limit(5)->get();

        return view('usuarios.perfil', compact('user', 'reservas'));
    }

    public function showRegistrationForm($tipoRegistro)
    {
        return view('auth.register', compact($tipoRegistro));
    }


    public function misReservas(Request $request)
    {
        $reservas = $request->user()->reservas()->paginate();

        return view('usuarios.reservas', compact('reservas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function banear(Request $request, $id)
    {
        $usuario = User::find(Crypt::decrypt($id));
        $responsable = isset($request->responsable) ? $request->responsable : $request->user()->dependencia;
        $canBlock = true;


        foreach ($usuario->bloqueos as $bloqueo) {
            if ($bloqueo->actual && $bloqueo->responsable == $responsable) {
                $canBlock = false;
            }
        }


        if ($canBlock) {
            $baneo = new Baneado();
            $baneo->motivo = $request->motivo;
            $baneo->actual = true;
            $baneo->responsable = $responsable;
            $baneo->usuario()->associate($usuario);
            $baneo->save();
            $usuario->notify(new UserEstado($baneo, 'baneado'));
            return back()->with('mensaje', 'Usuario baneado correctamente');
        } else {
            return back()->with('mensaje-error', 'Este usuario ya se encuentra baneado');
        }


    }

    public function habilitar(Request $request, $id)
    {
        $usuario = User::find(Crypt::decrypt($id));

        $hablitado = false;

        $temp = null;

        $responsable = isset($request->responsable) ? $request->responsable : $request->user()->dependencia;


        foreach ($usuario->bloqueos as $bloqueo) {
            if ($bloqueo->responsable == $responsable && $bloqueo->actual) {
                $temp = $bloqueo;
                $bloqueo->actual = false;
                $bloqueo->update();
                $hablitado = true;
                break;
            }
        }


        if ($hablitado) {

            $temp->created_at = Carbon::now();

            $usuario->notify(new UserEstado($temp, 'habilitado'));

            return back()->with('mensaje', 'Usuario habilitado correctamente');
        } else {
            return back()->with('mensaje-error', 'Este usuario no se encuentra baneado');
        }
    }


    public function escuelas(Request $request)
    {
        if (!$request->ajax()) {
            abort(401, 'No Autorizado!');
        }

        $escuelas = User::escuelas()->notNull('escuela')->get();

        return response()->json($escuelas);

    }

    public function escuelasByNombre(Request $request)
    {
//        if (!$request->ajax()) {
//            abort(401, 'No Authorizado');
//        }
//
//
//        $term = trim($request->q);
//
//        if (empty($term)) {
//            return response()->json([]);
//        }
//
//        $escuelas = User::escuelas($term);
//
//        $formatted_escuelas = [];
//
//        foreach ($escuelas as $escuela) {
//            $formatted_escuelas[] = ['id' => $escuela->escuela, 'text' => $escuela->escuela];
//        }
//
//        return response()->json($formatted_escuelas);

    }

    public function dependencias(Request $request)
    {
        if (!$request->ajax()) {
            abort(401, 'No Autorizado!');
        }

        $dependencias = User::dependencias()->notNull('dependencia')->get();

        return response()->json($dependencias);
    }

    public function dependenciasByNombre(Request $request)
    {
//        if (!$request->ajax()) {
//            abort(401, 'No Authorizado');
//        }
//
//
//        $term = trim($request->q);
//
//        if (empty($term)) {
//            return response()->json([]);
//        }
//
//        $escuelas = User::dependencias($term);
//
//        $formatted_dependencias = [];
//
//        foreach ($escuelas as $escuela) {
//            $formatted_dependencias[] = ['id' => $escuela->dependencia, 'text' => $escuela->dependencia];
//        }
//
//        return response()->json($formatted_dependencias);
//
    }

    public function getContactForm($user)
    {
        return view('usuarios.contact', ['user' => User::find(Crypt::decrypt($user))]);
    }

    public function postContactForm(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'asunto' => 'required',
            'mensaje' => 'required'

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            try {
                $contacto = ['asunto' => $request->asunto, 'mensaje' => $request->mensaje];

                Mail::to($request->email)->send(new ContactEmail($contacto));

                return back()->with('mensaje', 'Su mensaje ha sido enviado correctamente!');
            } catch (Exception $exception) {
                return back()->with('mensaje_error', 'No se pudo enviar el mensaje');
            }
        }


    }
}
