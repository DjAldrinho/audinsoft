<?php

namespace App\Http\Controllers;

use App\Activo;
use App\Equipo;
use App\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ActivoController extends Controller
{
    /**
     * ActivoController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->user()->superadministrador) {
            $activos = Activo::orderBy('nombre')->paginate(25);
        } else {
            $activos = Activo::dependencia($request->user()->dependencia)->orderBy('nombre')->paginate(25);
        }


        return view('activos.index', compact('activos'));
    }

    public function indexEquipos()
    {
        $equipos = Equipo::paginate(25);

        return view('activos.indexEquipo', compact('equipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('activos.register');
    }

    public function createEquipo(Request $request)
    {

        if ($request->user()->superadministrador) {
            $activos = Activo::estado('Disponible')->paginate(10);
        } else {
            $activos = Activo::dependencia($request->user()->dependencia)->paginate(15);
        }


        return view('activos.register-equipo', compact('activos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|min:3',
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:100',
            'serial' => 'required_if:has_serial,on|nullable|alpha_num|unique:activos',
            'cantidad' => 'required_without:has_serial|nullable|integer|min:1',
            'tipo' => 'string|required',
            'dependencia' => 'required|string',
            'descripcion' => 'string|nullable',
        ], [
            'serial.required_if' => 'Serial es obligatorio cuando el campo tiene serial se encuentra seleccionado',
            'cantidad.required_without' => 'El campo cantidad es obligatorio cuando el campo tiene serial no esta seleccionado'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            Activo::create([
                'nombre' => ucwords($request['nombre']),
                'marca' => ucwords($request['marca']),
                'modelo' => ucwords($request['modelo']),
                'serial' => $request['serial'],
                'cantidad' => $request['cantidad'],
                'tipo' => ucwords($request['tipo']),
                'grupo' => ucwords($request['grupo']),
                'dependencia' => ucwords($request['dependencia']),
                'descripcion' => $request['descripcion'],
                'estado' => 'Disponible'
            ]);


            return redirect()->route('listar-activos')->with('mensaje', 'El Activo ' . $request->nombre . ' Ha Sido creado Correctamente');
        }


    }

    public function storeEquipo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|min:3|unique:equipos',
            'activos' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $equipo = new Equipo();

            $equipo->nombre = $request->nombre;

            $equipo->descripcion = $request->descripcion;

            $equipo->estado = 'Disponible';

            $equipo->save();

            $equipo->activos()->attach($request->activos);

            return redirect()->route('listar-equipos')->with('mensaje', 'El equipo ' . $request->nombre . ' Ha Sido creado Correctamente');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Activo $activo
     * @return \Illuminate\Http\Response
     */
    public function show(Activo $activo)
    {
        return view('activos.show', compact('activo'));
    }

    public function showEquipo(Equipo $equipo)
    {
        return view('activos.showEquipo', compact('equipo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activo $activo
     * @return \Illuminate\Http\Response
     */
    public function edit(Activo $activo)
    {
        return view('activos.edit', compact('activo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Activo $activo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activo $activo)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|min:3',
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:100',
            'serial' => 'required_without:cantidad|alpha_num', Rule::unique('activos')->ignore($activo->id),
            'cantidad' => 'required_without:serial|integer|min:1',
            'tipo' => 'string|required',
            'dependencia' => 'required|string',
            'descripcion' => 'string|nullable',
        ], [
            'serial.required_without' => 'El campo serial es obligatorio',
            'cantidad.required_without' => 'El campo cantidad es obligatorio'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $activo->update([
                'nombre' => $request['nombre'],
                'marca' => $request['marca'],
                'modelo' => $request['modelo'],
                'serial' => $request['serial'],
                'cantidad' => $request['cantidad'],
                'tipo' => $request['tipo'],
                'dependencia' => $request['dependencia'],
                'descripcion' => $request['descripcion']
            ]);

            return redirect()->route('ver-activo', $activo->id)->with('mensaje', 'El Activo ' . $request->nombre . ' Ha Sido Actualizado Correctamente');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activo $activo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activo $activo)
    {
        return null;
    }

    public function tipos(Request $request)
    {
        if (!$request->ajax()) {
            abort(401, 'No Autorizado!');
        }

        $tipos = Activo::tipos()->notNull('tipo')->get();


        return response()->json($tipos);
    }

    public function marcas(Request $request)
    {
        if (!$request->ajax()) {
            abort(401, 'No Autorizado!');
        }

        $marcas = Activo::marcas()->notNull('marca')->get();


        return response()->json($marcas);
    }

    public function marcarMantenimiento(Activo $activo)
    {

        $activo->estado = 'Mantenimiento';

        $activo->update();

        return redirect()->route('ver-activo', $activo->id)->with('mensaje', 'El Activo ' . $activo->nombre . ' Ha Sido Actualizado Correctamente');
    }
}
