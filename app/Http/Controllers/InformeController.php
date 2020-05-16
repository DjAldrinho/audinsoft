<?php

namespace App\Http\Controllers;

use App\Activo;
use App\Aula;
use App\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformeController extends Controller
{

    private $fechaActual;

    /**
     * InformeController constructor.
     */
    public function __construct()
    {
        $this->fechaActual = Carbon::now();
        $this->middleware('auth');
    }


    /*
     * # de reservas en el dia
     */
    public function countReservasDay(Request $request)
    {

        $reservas = array();

        foreach ($request->user()->reservas as $reserva) {

            if ($reserva->fecha_reserva->format('y-m-d') == $this->fechaActual->format('y-m-d') && $reserva->dependencia == $request->tipoReserva) {
                array_push($reservas, $reserva);
            }
        }

        return response()->json(count($reservas));
    }

    /*
     * # de reservas en el mes
     */
    public function countReservasMonth(Request $request)
    {

        $reservas = array();

        foreach ($request->user()->reservas as $reserva) {

            if ($reserva->fecha_reserva->month === $this->fechaActual->month && $reserva->dependencia == $request->tipoReserva) {
                array_push($reservas, $reserva);
            }
        }

        return response()->json(count($reservas));
    }

    /*
     * # de reservas en el año
     */
    public function countReservasYear(Request $request)
    {

        $reservas = array();

        foreach ($request->user()->reservas as $reserva) {

            if ($reserva->fecha_reserva->year === $this->fechaActual->year && $reserva->dependencia == $request->tipoReserva) {
                array_push($reservas, $reserva);
            }
        }

        return response()->json(count($reservas));
    }

    /*
     * Activo mas reservado
     */
    public function countActivoPopular(Request $request)
    {
        return response()->json($this->getActivoPopular($request->user()->superadministrador, $request->user()->dependencia));
    }

    /*
     * Tipo de activo mas reservado
     */
    public function countActivoByTipoPopular(Request $request)
    {

        return response()->json($this->getTipoActivoPopular($request->user()->superadministrador, $request->user()->dependencia));
    }

    /*
     * Activos sin stock
     */
    public function countMinActivo(Request $request)
    {
        $countActivo = null;

        if ($request->user()->superadministrador) {
            $countActivo = DB::table('activos')
                ->select('nombre')
                ->whereNull('serial')
                ->where('cantidad', '=', 1)
                ->inRandomOrder()
                ->limit(3)
                ->get();
        } else {
            $countActivo = DB::table('activos')
                ->select('nombre')
                ->whereNull('serial')
                ->where('cantidad', '=', 1)
                ->where('dependencia', '=', $request->user()->dependencia)
                ->inRandomOrder()
                ->limit(3)
                ->get();
        }


        return response()->json($countActivo);

    }

    /*
     * Activos con mas stock
     */
    public function countMaxActivo(Request $request)
    {
        $maxActivo = null;

        if ($request->user()->superadministrador) {
            $maxActivo = DB::table('activos')
                ->selectRaw('nombre, cantidad')
                ->whereNull('serial')
                ->orderBy('cantidad', 'desc')
                ->first();
        } else {
            $maxActivo = DB::table('activos')
                ->selectRaw('nombre, cantidad')
                ->whereNull('serial')
                ->where('dependencia', '=', $request->user()->dependencia)
                ->orderBy('cantidad', 'desc')
                ->first();
        }


        return response()->json($maxActivo);

    }

    /*
     * Activos by Estado
     */

    public function countActivosByEstado(Request $request)
    {
        return response()->json($this->getActivosByEstado($request->estado, $request->user()->superadministrador, $request->user()->dependencia));
    }

    public function marcasActivoPopular(Request $request)
    {
        $marcas = null;

        if ($request->user()->superadministrador) {

            $marcas = DB::table('activos')
                ->select('marca')
                ->groupBy('marca')
                ->orderBy(\DB::raw('count(activos.marca)'), 'desc')
                ->limit(4)
                ->get();
        } else {
            $marcas = DB::table('activos')
                ->select('marca')
                ->where('dependencia', '=', $request->user()->dependencia)
                ->orderBy(\DB::raw('count(marca)'), 'desc')
                ->groupBy('marca')
                ->limit(4)
                ->get();
        }

        return response()->json($marcas);

    }

    public function activoUltimaVezReservado($idActivo)
    {

        $activo = Activo::find($idActivo);

        $fechaReserva = null;

        $reserva = $activo->reservas()
            ->select('fecha_reserva')
            ->where('estado', '=', 'Finalizada')
            ->orderByDesc('fecha_reserva')
            ->first();

        if (isset($reserva)) {
            $fechaReserva = $reserva->fecha_reserva->format('d/m/Y');
        } else {
            $fechaReserva = 'No registra reservas';
        }


        return response()->json($fechaReserva);
    }

    public function vecesReservadoActivo($idActivo)
    {

        $activo = Activo::find($idActivo);

        $countReservas = $activo->reservas()->where('estado', '=', 'Finalizada')->count();

        return response()->json($countReservas);
    }

    /*
     * Aulas by Estado
     */

    public function countAulasByEstado(Request $request)
    {
        $aulas = null;

        if ($request->user()->superadministrador) {
            $aulas = Aula::estado($request->estado)->count();
        } else if ($request->user()->dependencia == 'Bienestar Universitario') {
            $aulas = Aula::estado($request->estado)->tipo('Escenario Deportivo')->count();
        } else {
            $aulas = Aula::estado($request->estado)->tipo('Aula')->count();
        }


        return response()->json($aulas);
    }

    public function aulaUltimaVezReservado($idAula)
    {

        $aula = Aula::find($idAula);

        $fechaReserva = null;

        $reserva = $aula->reservas()
            ->select('fecha_reserva')
            ->where('estado', '=', 'Finalizada')
            ->orderByDesc('fecha_reserva')
            ->first();

        if (isset($reserva)) {
            $fechaReserva = $reserva->fecha_reserva->format('d/m/Y');
        } else {
            $fechaReserva = 'No registra reservas';
        }


        return response()->json($fechaReserva);
    }

    public function vecesReservadoAula($idAula)
    {

        $aula = Aula::find($idAula);

        $countReservas = $aula->reservas()->where('estado', '=', 'Finalizada')->count();

        return response()->json($countReservas);
    }

    /*
     * Count Reservas By Estado
     */

    public function countReservasByEstado(Request $request)
    {
        $reservas = null;

        if ($request->user()->superadministrador) {
            $reservas = Reserva::estado($request->estado)->count();
        } else {
            $reservas = Reserva::estado($request->estado)->tipo($request->user()->dependencia)->count();
        }


        return response()->json($reservas);
    }

    /*
     *
     * Count reservas por dependencia
     */

    public function countReservasByDependencia(Request $request)
    {

        $reservas = Reserva::tipo($request->dependencia)->ByUsuario($request->user()->id)->count();

        return response()->json($reservas);

    }

    /*
     * Reportes
     *
     */

    public function reporteActivos(Request $request)
    {
        $activos = [];

        foreach ($this->getActivos($request->user()->superadministrador, $request->user()->dependencia) as $activo) {
            array_push($activos, [
                'Nombre' => ucwords($activo->nombre),
                'Marca' => ucwords($activo->marca),
                'Modelo' => ucwords($activo->modelo),
                'Serial' => $activo->serial,
                'Cantidad' => $activo->cantidad,
                'Dependencia' => ucwords($activo->dependencia),
                'Descripcion' => ucwords($activo->descripcion),
                'Tipo' => ucwords($activo->tipo),
                'Estado' => ucwords($activo->estado)
            ]);
        }

        \Maatwebsite\Excel\Facades\Excel::create('Reportes de activos del dia ' . date('d/m/Y'), function ($excel) use ($activos) {
            $excel->sheet('Reporte de activos', function ($sheet) use ($activos) {

                $sheet->fromArray($activos);

                /*--Estilo--*/
                $sheet->setStyle(array(
                    'font' => array(
                        'name' => 'Calibri',
                        'size' => 12,
                        'bold' => true
                    )
                ));

                $sheet->setAutoFilter('A1:I1');
                /*--color de cabecera--*/
                $sheet->cells('A1:I1', function ($cells) {

                    $cells->setBackground('#989898');
                    $cells->setFontColor('#000000');

                });
            });
        })->download('xlsx');
    }

    public function reporteGeneralActivos(Request $request)
    {
        $data = [
            'tipo_activo' => $this->getTipoActivoPopular($request->user()->superadministrador, $request->user()->dependencia),
            'activo_popular' => $this->getActivoPopular($request->user()->superadministrador, $request->user()->dependencia),
            'date' => Carbon::now(),
            'total_activos' => count($this->getActivos($request->user()->superadministrador, $request->user()->dependencia)),
            'pendientes' => $this->getActivosByEstado('Pendiente_reserva', $request->user()->superadministrador, $request->user()->dependencia),
            'disponibles' => $this->getActivosByEstado('Disponible', $request->user()->superadministrador, $request->user()->dependencia),
            'mantenimiento' => $this->getActivosByEstado('Mantenimiento', $request->user()->superadministrador, $request->user()->dependencia),
            'ocupados' => $this->getActivosByEstado('Ocupado', $request->user()->superadministrador, $request->user()->dependencia),
        ];


        $pdf = \PDF::loadView('reportes.activos', $data);

        return $pdf->stream();

        //return view('reportes.activos', $data);

    }

    public function reporteAulas(Request $request)
    {
        $aulas = [];

        foreach ($this->getAulas($request->user()->superadministrador, $request->user()->dependencia) as $aula) {
            array_push($aulas, [
                'Nombre' => ucwords($aula->nombre),
                'Sede' => ucwords($aula->sede),
                'Descripcion' => ucwords($aula->descripcion),
                'Tipo' => ucwords($aula->tipo),
                'Estado' => ucwords($aula->estado)
            ]);
        }

        \Maatwebsite\Excel\Facades\Excel::create('Reportes de aulas del dia ' . date('d/m/Y'), function ($excel) use ($aulas) {
            $excel->sheet('Reporte de aulas', function ($sheet) use ($aulas) {

                $sheet->fromArray($aulas);

                /*--Estilo--*/
                $sheet->setStyle(array(
                    'font' => array(
                        'name' => 'Calibri',
                        'size' => 12,
                        'bold' => true
                    )
                ));

                $sheet->setAutoFilter('A1:E1');
                /*--color de cabecera--*/
                $sheet->cells('A1:E1', function ($cells) {

                    $cells->setBackground('#989898');
                    $cells->setFontColor('#000000');

                });
            });
        })->download('xlsx');
    }

    public function reporteGeneralAulas(Request $request)
    {
        $data = [
            'date' => Carbon::now(),
            'total_aulas' => count($this->getAulas($request->user()->superadministrador, $request->user()->dependencia)),
            'pendientes' => $this->getAulasByEstado('Pendiente_reserva', $request->user()->superadministrador, $request->user()->dependencia),
            'disponibles' => $this->getAulasByEstado('Disponible', $request->user()->superadministrador, $request->user()->dependencia),
            'mantenimiento' => $this->getAulasByEstado('Mantenimiento', $request->user()->superadministrador, $request->user()->dependencia),
            'ocupados' => $this->getAulasByEstado('Ocupado', $request->user()->superadministrador, $request->user()->dependencia),
        ];

        $pdf = \PDF::loadView('reportes.aulas', $data);

        return $pdf->stream();
    }

    public function reporteReservas(Request $request)
    {
        $reservas = [];

        foreach ($this->getReservas($request->user()->superadministrador, $request->user()->dependencia) as $reserva) {
            array_push($reservas, [
                'Codigo' => $reserva->codigo_reserva,
                'Responsable' => $reserva->usuario->nombreCompleto,
                'Fecha' => $reserva->fecha_reserva->format('d/m/Y'),
                'Hora Inicial' => $reserva->hora_inicio,
                'Hora Final' => $reserva->hora_final,
                'tipo' => ucwords($reserva->tipo),
                'Aula' => isset($reserva->aula) ? $reserva->aula->nombre : 'NA',
                'Actvos' => ($this->generateActivos($reserva->activos) != '' ? $this->generateActivos($reserva->activos) : 'NA'),
                'Estado' => ucwords($reserva->estado),
                'Descripcion' => ucwords($reserva->descripcion)
            ]);
        }

        \Maatwebsite\Excel\Facades\Excel::create('Reportes de reservas del dia ' . date('d/m/Y'), function ($excel) use ($reservas) {
            $excel->sheet('Reporte de reservas', function ($sheet) use ($reservas) {

                $sheet->fromArray($reservas);

                /*--Estilo--*/
                $sheet->setStyle(array(
                    'font' => array(
                        'name' => 'Calibri',
                        'size' => 12,
                        'bold' => true
                    )
                ));

                $sheet->setAutoFilter('A1:J1');
                /*--color de cabecera--*/
                $sheet->cells('A1:J1', function ($cells) {

                    $cells->setBackground('#989898');
                    $cells->setFontColor('#000000');

                });
            });
        })->download('xlsx');
    }


    /*
     * Utils
     */

    private function generateActivos($activos)
    {
        $mensaje = '';
        if (count($activos) > 0) {
            foreach ($activos as $activo) {
                $mensaje .= ',' . $activo->nombre;
            }
        }

        return $mensaje;
    }

    /*
     *
     *  Datos
     *
     */

    /**
     * @param $superadministrador
     * @param null $dependencia
     * @return \Illuminate\Support\Collection
     */
    private function getActivos($superadministrador, $dependencia = null)
    {
        if ($superadministrador) {
            $activos = Activo::orderBy('nombre')->get();
        } else {
            $activos = Activo::dependencia($dependencia)->orderBy('nombre')->get();
        }

        return $activos;
    }

    /**
     * @param $superadministrador
     * @param null $dependencia
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    private function getTipoActivoPopular($superadministrador, $dependencia = null)
    {
        if ($superadministrador) {
            $tipo_activo = Activo::selectRaw('activos.tipo, count(activos.tipo) as frecuencia')
                ->join('reservas_activos', 'reservas_activos.activo_id', '=', 'activos.id')
                ->join('reservas', 'reservas_activos.reserva_id', '=', 'reservas.id')
                ->where('reservas.estado', '=', 'Finalizada')
                ->groupBy('activos.tipo')
                ->orderBy(DB::raw('count(activos.tipo)'), 'desc')
                ->first();
        } else {
            $tipo_activo = Activo::selectRaw('activos.tipo, count(activos.tipo) as frecuencia')
                ->join('reservas_activos', 'reservas_activos.activo_id', '=', 'activos.id')
                ->join('reservas', 'reservas_activos.reserva_id', '=', 'reservas.id')
                ->where('reservas.estado', '=', 'Finalizada')
                ->where('activos.dependencia', '=', $dependencia)
                ->groupBy('activos.tipo')
                ->orderBy(DB::raw('count(activos.tipo)'), 'desc')
                ->first();
        }

        return $tipo_activo;
    }

    /**
     * @param $superadministrador
     * @param null $dependencia
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    private function getActivoPopular($superadministrador, $dependencia = null)
    {
        if ($superadministrador) {
            $activos = Activo::selectRaw('activos.nombre, count(activos.nombre) as frecuencia')
                ->join('reservas_activos', 'reservas_activos.activo_id', '=', 'activos.id')
                ->join('reservas', 'reservas_activos.reserva_id', '=', 'reservas.id')
                ->where('reservas.estado', '=', 'Finalizada')
                ->groupBy('activos.nombre')
                ->orderBy(DB::raw('count(activos.nombre)'), 'desc')
                ->first();
        } else {
            $activos = Activo::selectRaw('activos.nombre, count(activos.nombre) as frecuencia')
                ->join('reservas_activos', 'reservas_activos.activo_id', '=', 'activos.id')
                ->join('reservas', 'reservas_activos.reserva_id', '=', 'reservas.id')
                ->where('dependencia', '=', $dependencia)
                ->where('reservas.estado', '=', 'Finalizada')
                ->groupBy('activos.nombre')
                ->orderBy(DB::raw('count(activos.nombre)'), 'desc')
                ->first();
        }

        return $activos;
    }

    /**
     * @param $estado
     * @param $superadministrador
     * @param $dependencia
     * @return mixed
     */
    private function getActivosByEstado($estado, $superadministrador, $dependencia)
    {
        if ($superadministrador) {
            $activos = Activo::estado($estado)->count();
        } else {
            $activos = Activo::estado($estado)->dependencia($dependencia)->count();
        }

        return $activos;
    }

    /**
     * @param $superadministrador
     * @param null $dependencia
     */
    private function getAulas($superadministrador, $dependencia = null)
    {
        if ($superadministrador) {
            $aulas = Aula::orderBy('nombre')->get();
        } else if ($dependencia == 'Infraestructura') {
            $aulas = Aula::tipo('Aula')->orderBy('nombre')->get();
        } else {
            $aulas = Aula::tipo('Escenario Deportivo')->orderBy('nombre')->get();
        }

        return $aulas;
    }

    /**
     * @param $estado
     * @param $superadministrador
     * @param $dependencia
     * @return mixed
     */
    private function getAulasByEstado($estado, $superadministrador, $dependencia)
    {
        if ($superadministrador) {
            $aulas = Aula::estado($estado)->count();
        } else if ($dependencia == 'Infraestructura') {
            $aulas = Aula::estado($estado)->tipo('Aula')->count();
        } else {
            $aulas = Aula::estado($estado)->tipo('Escenario Deportivo')->count();
        }

        return $aulas;
    }

    private function getReservas($superadministrador, $dependencia = null)
    {
        if ($superadministrador) {
            $reservas = Reserva::orderBy('fecha_reserva')->get();
        } else {
            $reservas = Reserva::tipo(strtolower($dependencia))->orderBy('nombre')->get();
        }

        return $reservas;
    }
}
