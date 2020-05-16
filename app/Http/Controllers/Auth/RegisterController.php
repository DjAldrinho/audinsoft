<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'codigo_usuario' => 'required_if:tipo,!=,Administrativo|string|nullable|max:50|unique:users',
            'identificacion' => 'required|string|max:50|unique:users',
            'telefono' => 'nullable|numeric|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'tipo' => 'string|required',
            'escuela' => 'required_if:tipo,!=,Administrativo|string|nullable',
            'dependencia' => 'required_if:tipo,Administrativo|string|nullable',
            'terminos' => 'accepted'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
            'codigo_usuario' => $data['codigo_usuario'],
            'identificacion' => $data['identificacion'],
            'telefono' => $data['telefono'],
            'tipo' => $data['tipo'],
            'dependencia' => isset($data['dependencia'])?$data['dependencia']:$data['dependenciaTemp'],
            'escuela' => isset($data['escuela'])?$data['escuela']:$data['escuelaTemp'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
