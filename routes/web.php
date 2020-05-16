<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::get('pre-register', function () {
    return view('home-register');
});


// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register/{tipo}', 'RegisterController@showRegistrationForm')->name('get-register');
$this->post('register', 'RegisterController@register')->name('post-register');
Route::get('search/{tipo}/{codigo_identificacion}', 'Registercontroller@searchUser');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');


Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix' => '/usuarios'], function () {
    Route::get('/listar', 'PersonaController@index')->name('listar-usuarios')->middleware('can:action,App\User');
    Route::get('/ver/{usuario}', 'PersonaController@show')->name('ver-usuario')->middleware('can:action,App\User');;
    Route::get('/perfil', 'PersonaController@perfil')->name('perfil-usuario');
    Route::get('/mis-reservas', 'PersonaController@misReservas')->name('mis-reservas');
    Route::put('/habilitar/{usuario}', 'PersonaController@habilitar')->name('habilitar-usuario')->middleware('can:action,App\User');
    Route::put('/banear/{usuario}', 'PersonaController@banear')->name('banear-usuario')->middleware('can:action,App\User');

    Route::get('/escuelas', 'PersonaController@escuelas');
    Route::get('/escuelas/{nombre}', 'PersonaController@escuelasByNombre');
    Route::get('/dependencias', 'PersonaController@dependencias');
    Route::get('/dependencias/{nombre}', 'PersonaController@dependenciasByNombre');

    Route::get('/contactar/{user}', 'PersonaController@getContactForm')->name('contactar-usuario');

    Route::post('/contactar', 'PersonaController@postContactForm')->name('contactar-usuario');

});
Route::group(['prefix' => '/activos'], function () {
    Route::get('/listar', 'ActivoController@index')->name('listar-activos')->middleware('can:action,App\Activo');
    Route::get('/listar-equipo', 'ActivoController@indexEquipos')->name('listar-equipos')->middleware('can:addEquipo,App\Activo');
    Route::get('/registro-equipo', 'ActivoController@createEquipo')->name('registro-equipo')->middleware('can:action,App\Activo');
    Route::post('/registro-equipo', 'ActivoController@storeEquipo')->name('registro-equipo')->middleware('can:addEquipo,App\Activo');
    Route::get('/registro', 'ActivoController@create')->name('registro-activo')->middleware('can:action,App\Activo');
    Route::post('/registro', 'ActivoController@store')->name('registro-activo')->middleware('can:action,App\Activo');
    Route::get('/ver/{activo}', 'ActivoController@show')->name('ver-activo')->middleware('can:modify,activo');
    Route::get('/ver-equipo/{equipo}', 'ActivoController@showEquipo')->name('ver-equipo')->middleware('can:addEquipo,App\Activo');
    Route::get('/editar/{activo}', 'ActivoController@edit')->name('editar-activo')->middleware('can:modify,activo');
    Route::get('/editar-equipo/{equipo}', 'ActivoController@editEquipo')->name('editar-equipo')->middleware('can:addEquipo,App\Activo');
    Route::put('/editar/{activo}', 'ActivoController@update')->name('editar-activo')->middleware('can:modify,activo');
    Route::put('/editar-equipo/{equipo}', 'ActivoController@updateEquipo')->name('editar-equipo')->middleware('can:addEquipo,App\Activo');
    Route::get('/marcar/{activo}', 'ActivoController@marcarMantenimiento')->name('marcar-activo')->middleware('can:modify,activo');

//    Route::delete('/eliminar/{activo}', 'ActivoController@destroy')->name('eliminar-activo');

    //Tipos
    Route::get('/tipos', 'ActivoController@tipos');
    Route::get('/marcas', 'ActivoController@marcas');

});
Route::group(['prefix' => '/aulas'], function () {
    Route::get('/listar', 'AulaController@index')->name('listar-aulas')->middleware('can:action,App\Aula');
    Route::get('/registro', 'AulaController@create')->name('registro-aula')->middleware('can:action,App\Aula');
    Route::post('/registro', 'AulaController@store')->name('registro-aula')->middleware('can:action,App\Aula');
    Route::get('/ver/{aula}', 'AulaController@show')->name('ver-aula')->middleware('can:modify,aula');
    Route::get('/editar/{aula}', 'AulaController@edit')->name('editar-aula')->middleware('can:modify,aula');
    Route::put('/editar/{aula}', 'AulaController@update')->name('editar-aula')->middleware('can:modify,aula');
//    Route::delete('/eliminar/{aula}', 'ActivoController@destroy')->name('eliminar-aula')->middleware('can:delete,App\Aula');
});
Route::group(['prefix' => '/reservas'], function () {
    Route::get('/listar', 'ReservaController@index')->name('listar-reservas')->middleware('can:action,App\Reserva');
    Route::get('/ver/{reserva}', 'ReservaController@show')->name('ver-reserva')->middleware('can:view,reserva');
    Route::get('/audiovisuales/{tipo}', 'ReservaController@reservaAudiovisuales')->name('reservar-audiovisuales');
    Route::get('/deportivos', 'ReservaController@reservaDeportivos')->name('reservar-deportivos');
    Route::get('/aulas', 'ReservaController@reservaAulas')->name('reservar-aulas');
    Route::get('/escenarios', 'ReservaController@index')->name('reservar-escenarios');
    Route::get('/findByCodigo/{reserva}', 'ReservaController@findByCodigoReserva');
    Route::get('/aprobar/{reserva}', 'ReservaController@aprobar')->name('aprobar-reserva')->middleware('can:modify,reserva');
    Route::get('/marcar/{reserva}', 'ReservaController@marcar')->name('marcar-reserva')->middleware('can:modify,reserva');
    Route::get('/finalizar/{reserva}', 'ReservaController@finalizar')->name('finalizar-reserva')->middleware('can:view,reserva');
    Route::put('/rechazar/{reserva}', 'ReservaController@rechazar')->name('rechazar-reserva')->middleware('can:modify,reserva');
    Route::post('/registro/{dependencia}/{tipo}', 'ReservaController@store')->name('registro-reserva');
});
Route::group(['prefix' => '/informes'], function () {
    /*
     * Reservas
     */
    Route::get('/count-reservas-day/{tipoReserva}', 'InformeController@countReservasDay');
    Route::get('/count-reservas-month/{tipoReserva}', 'InformeController@countReservasMonth');
    Route::get('/count-reservas-year/{tipoReserva}', 'InformeController@countReservasYear');
    Route::get('/reporte-reservas', 'InformeController@reporteReservas')->name('reporte-reservas');
    Route::get('/reporte-general-reservas', 'InformeController@reporteGeneralReservas')->name('reporte-general-reservas');
    /*
     * Activos
     */
    Route::get('/count-activo-popular', 'InformeController@countActivoPopular');
    Route::get('/count-tipo-activo-popular', 'InformeController@countActivoByTipoPopular');
    Route::get('/count-min-activo', 'InformeController@countMinActivo');
    Route::get('/count-max-activo', 'InformeController@countMaxActivo');
    Route::get('/count-activo-estado/{estado}', 'InformeController@countActivosByEstado');
    Route::get('/marcas-activo-popular', 'InformeController@marcasActivoPopular');
    Route::get('/ultima-vez-reservado-activo/{activo}', 'InformeController@activoUltimaVezReservado');
    Route::get('/count-veces-reservado-activo/{activo}', 'InformeController@vecesReservadoActivo');
    Route::get('/reporte-activos', 'InformeController@reporteActivos')->name('reporte-activos');
    Route::get('/reporte-general-activos', 'InformeController@reporteGeneralActivos')->name('reporte-general-activos');

    /*
     *  Aulas
     */
    Route::get('/count-aula-estado/{estado}', 'InformeController@countAulasByEstado');
    Route::get('/ultima-vez-reservado-aula/{aula}', 'InformeController@aulaUltimaVezReservado');
    Route::get('/count-veces-reservado-aula/{aula}', 'InformeController@vecesReservadoAula');
    Route::get('/reporte-aulas', 'InformeController@reporteAulas')->name('reporte-aulas');
    Route::get('/reporte-general-aulas', 'InformeController@reporteGeneralAulas')->name('reporte-general-aulas');
    /*
     * Reservas
     */
    Route::get('/count-reserva-estado/{estado}', 'InformeController@countReservasByEstado');
    Route::get('/count-reserva-dependencia/{dependencia}', 'InformeController@countReservasByDependencia');


});
Route::get('prueba', function () {


});