let reservas_module = angular.module('reservas_module', ['moment-picker']);

reservas_module.controller('reservasController', function ($scope, $http) {

    let tipo_reserva = angular.element("#tipo_reserva").val();

    $scope.reserva = {};

    $scope.mensaje = {};

    $scope.reserva.fecha_actual = moment().format("DD/MM/YYYY");

    $scope.minDateReserva = moment().add(1, 'day');

    $scope.minHoraInicioReserva = moment('7:00 AM', 'HH:mm a');

    $scope.maxHoraInicioReserva = moment('7:00 PM', 'HH:mm a');

    $scope.updateHoraFinal = function (value, newValue) {
        $scope.reserva.hora_final = newValue.add(3, 'h').format('hh:mm a');
    };

    $http.get("/informes/count-reservas-day/" + tipo_reserva).then(function (response) {
        if (response.data < 2) {
            $scope.bg_reservas_hoy = 'bg-green';
        } else if (response.data === 2) {
            $scope.bg_reservas_hoy = 'bg-yellow';
        } else {
            $scope.bg_reservas_hoy = 'bg-red';
        }

        $scope.number_reservas_hoy = response.data;
    });


    $http.get("/informes/count-reservas-month/" + tipo_reserva).then(function (response) {
        $scope.number_reservas_mes = response.data;
    });

    $http.get("/informes/count-reservas-year/" + tipo_reserva).then(function (response) {
        $scope.number_reservas_ano = response.data;
    });

    // $scope.searchAula = function () {
    //     $http.get("/reservas/findByCodigo/" + $scope.reserva.aula).then(function (response) {
    //         console.log(response.data);
    //         if (response.data.encontrado) {
    //             $scope.mensaje.type = "bg-primary";
    //             $scope.mensaje.text = response.data.mensaje + response.data.aula;
    //         } else {
    //             $scope.mensaje.type = "bg-warning";
    //             $scope.mensaje.text = response.data.mensaje;
    //         }
    //     });
    // };
});