<?php

namespace App\Http\Controllers;

use App\Aula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AulaController extends Controller
{
    /**
     * AulaController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Json
     */
    public function json()
    {
        $aulas = Aula::all();

        return $aulas->toJson();
    }

    public function disponiblesJson()
    {
        $aulas = Aula::disponibles();

        return $aulas->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $aulas = null;

        if ($request->user()->superadministrador) {
            $aulas = Aula::orderBy('nombre')->paginate(25);
        } else if ($request->user()->dependencia == 'Bienestar Universitario') {
            $aulas = Aula::orderBy('nombre')->tipo('Escenario Deportivo')->paginate(25);
        } else {
            $aulas = Aula::orderBy('nombre')->tipo('Aula')->paginate(25);
        }


        return view('aulas.index', compact('aulas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('aulas.register');
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
            'tipo' => 'string|required',
            'dependencia' => 'required',
            'capacidad' => 'required|numeric|min:1',
            'sede' => 'required|string',
            'descripcion' => 'string|nullable',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            Aula::create([
                'nombre' => ucwords($request['nombre']),
                'tipo' => ucwords($request['tipo']),
                'sede' => ucwords($request['sede']),
                'dependencia' => $request['dependencia'],
                'capacidad' => $request['capacidad'],
                'descripcion' => $request['descripcion'],
                'estado' => 'Disponible'
            ]);

            return redirect()->route('listar-aulas')->with('mensaje', 'El Aula ' . $request->nombre . ' Ha Sido creada Correctamente');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Aula $aula
     * @return \Illuminate\Http\Response
     */
    public function show(Aula $aula)
    {
        return view('aulas.show', compact('aula'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Aula $aula
     * @return \Illuminate\Http\Response
     */
    public function edit(Aula $aula)
    {
        return view('aulas.edit', compact('aula'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Aula $aula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aula $aula)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|min:3',
            'tipo' => 'string|required',
            'sede' => 'required|string',
            'descripcion' => 'string|nullable',
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $aula->update([
                'nombre' => $request['nombre'],
                'tipo' => $request['tipo'],
                'sede' => $request['sede'],
                'descripcion' => $request['descripcion']
            ]);

            return redirect()->route('ver-aula', $aula->id)->with('mensaje', 'El Aula ' . $request->nombre . ' Ha Sido Actualizada Correctamente');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Aula $aula
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aula $aula)
    {
        //
    }
}
