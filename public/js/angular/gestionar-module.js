let gestionarModule = angular.module('gestionar_module', []);

gestionarModule.controller('gestionarActivosController', function ($scope, $http) {

    let idActivo = angular.element("#idActivo").val();

    $http.get("/informes/count-activo-popular").then(function (response) {
        $scope.nombre_activo_reservado = (typeof response.data.nombre !== 'undefined') ? response.data.nombre : 'No hay reservas';
        $scope.frecuencia_activo_reservado = (typeof response.data.frecuencia !== 'undefined') ? response.data.frecuencia : 'No hay reservas';
    });

    $http.get("/informes/count-tipo-activo-popular").then(function (response) {
        $scope.nombre_tipo_activo_reservado = response.data.tipo != undefined ? response.data.tipo : 'No hay reservas';
        $scope.frecuencia_tipo_activo_reservado = response.data.frecuencia != undefined ? response.data.frecuencia : 'No hay reservas';
    });

    $http.get("/informes/count-min-activo").then(function (response) {
        $scope.activos = response.data;
    });

    $http.get("/informes/count-max-activo").then(function (response) {
        $scope.activo = response.data;
    });

    $http.get("/informes/count-activo-estado/disponible").then(function (response) {
        $scope.disponibles = response.data;
    });

    $http.get("/informes/count-activo-estado/ocupado").then(function (response) {
        $scope.ocupados = response.data;
    });

    $http.get("/informes/count-activo-estado/mantenimiento").then(function (response) {
        $scope.mantenimiento = response.data;
    });

    $http.get("/informes/count-activo-estado/pendiente_reserva").then(function (response) {
        $scope.pendientes = response.data;
    });

    $http.get("/informes/marcas-activo-popular").then(function (response) {
        $scope.marcas = response.data;
    });

    if (idActivo) {
        $http.get("/informes/ultima-vez-reservado-activo/" + idActivo).then(function (response) {
            $scope.fecha_reserva_activo = response.data;
        });

        $http.get("/informes/count-veces-reservado-activo/" + idActivo).then(function (response) {

            $scope.veces_reservado = response.data;

        });
    }


});

gestionarModule.controller('gestionarAulasController', function ($scope, $http) {

    let idAula = angular.element("#idAula").val();

    $http.get("/informes/count-aula-estado/disponible").then(function (response) {
        $scope.disponibles = response.data;
    });

    $http.get("/informes/count-aula-estado/ocupado").then(function (response) {
        $scope.ocupados = response.data;
    });

    $http.get("/informes/count-aula-estado/mantenimiento").then(function (response) {
        $scope.mantenimiento = response.data;
    });

    $http.get("/informes/count-aula-estado/pendiente_reserva").then(function (response) {
        $scope.pendientes = response.data;
    });


    if (idAula) {
        $http.get("/informes/ultima-vez-reservado-aula/" + idAula).then(function (response) {

            $scope.fecha_reserva_activo = response.data;
        });

        $http.get("/informes/count-veces-reservado-aula/" + idAula).then(function (response) {

            $scope.veces_reservado = response.data;

        });
    }
});

gestionarModule.controller('gestionarReservasController', function ($scope, $http) {
    $http.get("/informes/count-reserva-estado/activa").then(function (response) {
        $scope.activas = response.data;
    });

    $http.get("/informes/count-reserva-estado/finalizada").then(function (response) {
        $scope.finalizadas = response.data;
    });

    $http.get("/informes/count-reserva-estado/pendiente").then(function (response) {
        $scope.pendientes = response.data;
    });

    $http.get("/informes/count-reserva-estado/aprobada").then(function (response) {
        $scope.aprobadas = response.data;
    });

    $http.get("/informes/count-reserva-estado/rechazada").then(function (response) {
        $scope.rechazadas = response.data;
    });

    $http.get("/informes/count-reserva-dependencia/Servicios Audiovisuales").then(function (response) {
        $scope.audiovisuales = response.data;
    });

    $http.get("/informes/count-reserva-dependencia/bienestar universitario").then(function (response) {
        $scope.bienestar = response.data;
    });

    $http.get("/informes/count-reserva-dependencia/infraestructura").then(function (response) {
        $scope.infraestructura = response.data;
    });
});
