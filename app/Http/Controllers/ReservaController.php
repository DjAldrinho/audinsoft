<?php

namespace App\Http\Controllers;

use App\Activo;
use App\Aula;
use App\Equipo;
use App\Notifications\NewReserva;
use App\Notifications\NewReservaV2;
use App\Notifications\ReservaEstado;
use App\Reserva;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Mixed;

class ReservaController extends Controller
{
    /**
     * ReservaController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * @param $tipo
     * @return Mixed;
     */
    public function reservaAudiovisuales($tipo)
    {
        if ($tipo == 'activos') {

            $activos = Activo::dependencia('Servicios Audiovisuales')->estado('Disponible')->orderBy('nombre')->paginate(10);

            $equipos = Equipo::estado('Disponible')->paginate(5);

            return view('reservas.audiovisuales.activos', compact('activos', 'equipos'));
        } else if ($tipo == 'salas') {

            $aulas = Aula::dependencia('Servicios Audiovisuales')->paginate(10);

            return view('reservas.audiovisuales.salas', compact('aulas'));
        }

        return abort(404);
    }

    public function reservaDeportivos()
    {
        $aulas = Aula::tipo('Escenario Deportivo')->estado('Disponible')->orderBy('nombre')->paginate(10);

        return view('reservas.deportivos', compact('aulas'));
    }

    public function reservaAulas()
    {
        $aulas = Aula::tipo('Aula')->estado('disponible')->orderBy('nombre')->paginate(10);

        return view('reservas.aulas', compact('aulas'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $reservas = null;

        if ($request->user()->superadministrador) {
            $reservas = Reserva::orderByDesc('created_at')->paginate(25);
        } else {
            $reservas = Reserva::tipo($request->user()->dependencia)->orderByDesc('created_at')->paginate(25);
        }

        return view('reservas.index', compact('reservas'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->verifyNumberReservas($request->user(), $request->fecha_reserva)) {
            return back()->with('mensaje_error', 'Ya no puede realizar mas reservas para ese dia');
        } else {
            if ($request->dependencia === 'audiovisuales') {
                return $this->saveReservaAudiovisuales($request);
            } else {
                return $this->saveReservaAulas($request);
            }
        }


    }


    private function saveReservaAudiovisuales($request)
    {
        if ($request->tipo == 'activos') {
            $validator = Validator::make($request->all(), [
                'fecha_reserva' => 'required|date_format: "d/m/Y"',
                'hora_inicio' => 'required|date_format: "h:i a"',
                'hora_final' => 'required|date_format: "h:i a"',
                'descripcion_aula' => 'required',
                'equipo' => 'required_without:activos',
                'activos' => 'required_without:equipo'
            ], [
                'activos.max' => 'Solo se permite seleccionar 2 adicionales',
                'equipo.required_without' => 'Debe seleccionar al menos un equipo o activo adicional',
                'activos.required_without' => 'Debe seleccionar al menos un equipo o activo adicional'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $reserva = new Reserva();
                $reserva->fecha_reserva = $request->fecha_reserva;
                $reserva->hora_inicio = $request->hora_inicio;
                $reserva->hora_final = $request->hora_final;
                $reserva->tipo = 'Activos';
                $reserva->estado = 'Pendiente';
                $reserva->dependencia = 'Servicios Audiovisuales';
                $reserva->descripcion_aula = $request->descripcion_aula;
                $reserva->usuario()->associate($request->user());

                $reserva->save();

                if (isset($request->activos)) {
                    $reserva->activos()->attach($request->activos);
                }

                if (isset($request->equipo)) {
                    $equipo = Equipo::find($request->equipo);

                    $reserva->activos()->attach($equipo->activos);
                }

                $reserva->codigo_reserva = "RSVA" . Carbon::now()->format('dmy') . $reserva->id;

                $reserva->update();
            }

            return $this->redirectAndNotify($reserva);
        } else {
            return null;
        }
    }

    private function saveReservaAulas($request)
    {
        $validator = Validator::make($request->all(), [
            'fecha_reserva' => 'required|date_format: "d/m/Y"',
            'hora_inicio' => 'required|date_format: "h:i a"',
            'hora_final' => 'required|date_format: "h:i a"',
            'aula' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $reserva = new Reserva();

            $aula = Aula::find($request->aula);

            $reserva->fecha_reserva = $request->fecha_reserva;
            $reserva->hora_inicio = $request->hora_inicio;
            $reserva->hora_final = $request->hora_final;
            $reserva->tipo = $request->tipo;
            $reserva->estado = 'Pendiente';
            $reserva->aula()->associate($aula);
            $reserva->usuario()->associate($request->user());
            $reserva->save();
            $reserva->codigo_reserva = 'RSV' . strtoupper($request->tipo[0]) . Carbon::now()->format('dmy') . $reserva->id;
            $reserva->update();
        }

        return $this->redirectAndNotify($reserva);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Reserva $reserva
     * @return \Illuminate\Http\Response
     */
    public function show(Reserva $reserva)
    {
        return view('reservas.show', compact('reserva'));
    }

    public function findByCodigoReserva(Request $request)
    {
        $reserva = Reserva::codigo($request->reserva)->first();

        if (isset($reserva)) {
            if ($request->user()->id === $reserva->usuario->id) {
                if ($reserva->estado == 'Aprobada' || $reserva->estado == 'Activa') {
                    if (isset($reserva->aula)) {
                        return response()->json(['encontrado' => true, 'mensaje' => 'Resultados encontrados: ', 'aula' => $reserva->aula->nombre]);
                    } else {
                        return response()->json(['encontrado' => false, 'mensaje' => 'Esta reserva no posee un aula!']);
                    }
                } else {
                    return response()->json(['encontrado' => false, 'mensaje' => 'Esta reserva ha sido rechazada, finalizada o pendiente por aprobar!']);
                }
            } else {
                return response()->json(['encontrado' => false, 'mensaje' => 'Esta reserva no le pertenece!']);
            }
        } else {
            return response()->json(['encontrado' => false, 'mensaje' => 'Esta reserva no existe!']);
        }


    }

    public function aprobar(Reserva $reserva)
    {
        $reserva->estado = 'Aprobada';

        if (isset($reserva->aula)) {
            $reserva->aula->estado = 'Ocupado';
            $reserva->aula->update();
        }

        if (count($reserva->activos) > 0) {
            foreach ($reserva->activos as $activo) {
                if (!isset($activo->serial)) {
                    $activo->cantidad = $activo->cantidad - 1;

                    if ($activo->cantidad == 0) {
                        $activo->estado = 'Ocupado';
                    }

                } else {
                    $activo->estado = 'Ocupado';
                }
                $activo->update();
            }
        }

        $reserva->update();

        $reserva->usuario->notify(new ReservaEstado('aprobada', $reserva));

        return back()->with('mensaje', 'La reserva ha sido aprobada correctamente!');
    }


    public function finalizar(Reserva $reserva)
    {
        $reserva->estado = 'Finalizada';

        if (isset($reserva->aula)) {
            $reserva->aula->estado = 'Disponible';
            $reserva->aula->update();
        }

        if (count($reserva->activos) > 0) {
            foreach ($reserva->activos as $activo) {
                if (!isset($activo->serial)) {
                    $activo->cantidad = $activo->cantidad + 1;
                }
                $activo->estado = 'Disponible';
                $activo->update();
            }
        }

        $reserva->update();

        $reserva->usuario->notify(new ReservaEstado('finalizada', $reserva));

        return back()->with('mensaje', 'La reserva ha sido finalizada correctamente!');
    }

    public function marcar(Reserva $reserva)
    {
        $reserva->estado = 'Activa';

        $reserva->update();

        return back()->with('mensaje', 'La reserva ha sido marcada como activa!');
    }


    public function rechazar(Request $request, Reserva $reserva)
    {
        $reserva->estado = 'Rechazada';

        if (isset($reserva->aula)) {
            $reserva->aula->estado = 'Disponible';
            $reserva->aula->update();
        }

        if (count($reserva->activos) > 0) {
            foreach ($reserva->activos as $activo) {
                if (!isset($activo->serial)) {
                    $activo->cantidad = $activo->cantidad + 1;
                }

                $activo->estado = 'Disponible';
                $activo->update();
            }
        }

        $reserva->update();

        $reserva->usuario->notify(new ReservaEstado('rechazada', $reserva, $request->motivo));

        return back()->with('mensaje', 'La reserva ha sido rechazada correctamente!');
    }

    private function verifyNumberReservas(User $user, $fechaReserva)
    {
        $count = 0;
        foreach ($user->reservas as $reserva) {
            if ($reserva->fecha_reserva->format('d/m/Y') == $fechaReserva) {
                $count += 1;
            }
        }

        return $count > 3;
    }

    private function redirectAndNotify(Reserva $reserva)
    {
        $reserva->usuario->notify(new NewReserva($reserva));

        $usuarios = User::byDependencia(str_replace("_", " ", ucwords($reserva->tipo)))->administradores()->get();

        Notification::send($usuarios, new NewReservaV2($reserva));

        return redirect()->route('mis-reservas')->with('mensaje', 'Reserva creada correctamente! Se enviare un correo con su # de reserva');
    }
}
