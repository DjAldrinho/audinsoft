<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PDO;
use PDOException;

class RegisterController extends Controller
{

    use RedirectsUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm($tipo)
    {
        return view('auth.register', ['tipo' => $tipo]);
    }


    public function register(Request $request)
    {

        $this->validator($request->all(), $request->tipoRegistro)->validate();

        event(new Registered($user = $this->create($request->all(), $request->tipoRegistro)));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchUser(Request $request)
    {
        if ($request->tipo == 'docentes-administrativos') {

            $conexion = $this->administrativosConnection();

            $sql = $conexion->query("select *
                    from TB_USER LEFT JOIN TB_USER_DEPT ON TB_USER.nDepartmentIdn =TB_USER_DEPT.nDepartmentIdn
                    WHERE TB_USER.sUserID = '$request->codigo_identificacion'
                     ORDER BY TB_USER.sUserName ASC;");

            $usuario = new User();

            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                $usuario->nombre = ucwords(strtolower($row['sUserName']));
                $usuario->email = strtolower($row['sEmail']);
                $usuario->telefono = $row['sTelNumber'];
                $usuario->identificacion = $row['sUserID'];
                $usuario->dependencia = ucwords(strtolower($row['sName']));
            }

            if (!$usuario->isClean()) {
                return response()->json(['exist' => true, 'usuario' => $usuario, 'mensaje' => 'Resultados encontrados']);
            } else {
                return response()->json(['exist' => false, 'mensaje' => 'No existe usuario con esta identificacion']);
            }

        } else {
            $conexion = $this->estudiantesConnection();

            $stmt = $conexion->prepare("SELECT
              estudiantes.*,
              escuelas.nombre AS escuela,
              usuarios.email  AS email
              FROM estudiantes
              INNER JOIN escuelas ON estudiantes.escuela_id = escuelas.id
              INNER JOIN usuarios ON estudiantes.usuario_id = usuarios.id
              WHERE estudiantes.numero_documento = '$request->codigo_identificacion'");
            $stmt->execute();

            $usuario = new User();


            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $usuario->nombre = ucwords(strtolower($row['apellidos'])) . ' ' . ucwords(strtolower($row['nombres']));
                $usuario->email = strtolower($row['email']);
                $usuario->telefono = $row['telefono'];
                $usuario->identificacion = $row['numero_documento'];
                $usuario->escuela = $row['escuela'];
                $usuario->semestre = $row['semestre'];
            }

            if (!$usuario->isClean()) {
                return response()->json(['exist' => true, 'usuario' => $usuario, 'mensaje' => 'Resultados encontrados']);
            } else {
                return response()->json(['exist' => false, 'mensaje' => 'No existe usuario con esta identificacion']);
            }
        }

    }

    /**
     * @return \Illuminate\Http\JsonResponse|PDO
     */
    private function administrativosConnection()
    {
        try {
            $conexion = new PDO('sqlsrv:Server = ' . env('DB_SQL_SERVER') . ';Database = ' . env('DB_SQL_SERVER_DATABASE'), env('DB_SQL_SERVER_USERNAME'), env('DB_SQL_SERVER_PASSWORD'));
            return $conexion;
        } catch (PDOException $e) {
            return response()->json(['exist' => false, 'mensaje' => $e->getMessage()]);
        }
    }


    private function estudiantesConnection()
    {
        $servername = "192.168.32.66";
        $username = "aldrinho";
        $password = "012417";
        $database = "sinuprac";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            return response()->json(['exist' => false, 'mensaje' => $e->getMessage()]);
        }
    }


    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    private function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    private function registered(Request $request, $user)
    {
        //
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @param $tipoRegistro
     * @return \Illuminate\Contracts\Validation\Validator
     */

    private function validator(array $data, $tipoRegistro)
    {
        if ($tipoRegistro == 'estudiantes-egresados') {
            return Validator::make($data, [
                'nombre' => 'required|string|max:100',
                'email' => 'required|string|email|max:100|unique:users',
                'identificacion' => 'required|string|max:50|unique:users',
                'telefono' => 'nullable|numeric|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'rol' => 'required',
                'escuela' => 'required',
                'semestre' => 'required',
                'jornada' => 'required',
                'terminos' => 'accepted'
            ]);
        } else {
            return Validator::make($data, [
                'nombre' => 'required|string|max:100',
                'email' => 'required|string|email|max:100|unique:users',
                'identificacion' => 'required|string|max:50|unique:users',
                'telefono' => 'nullable|numeric|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'rol' => 'required',
                'dependencia' => 'required',
                'cargo' => 'required',
                'terminos' => 'accepted'
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @param $tipoRegistro
     * @return User
     */
    private function create(array $data, $tipoRegistro)
    {
        if ($tipoRegistro != 'estudiantes-egresados') {
            return User::create([
                'nombre' => $data['nombre'],
                'identificacion' => $data['identificacion'],
                'telefono' => $data['telefono'],
                'rol' => $data['rol'],
                'dependencia' => $data['dependencia'],
                'cargo' => $data['cargo'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
        } else {
            return User::create([
                'nombre' => $data['nombre'],
                'codigo_usuario' => $data['codigo_usuario'],
                'identificacion' => $data['identificacion'],
                'telefono' => $data['telefono'],
                'rol' => $data['rol'],
                'escuela' => $data['escuela'],
                'semestre' => $data['semestre'],
                'jornada' => $data['jornada'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
        }
    }


}
