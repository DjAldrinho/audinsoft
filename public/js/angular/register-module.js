let register_module = angular.module('register_module', []);

let tipoRegistro = angular.element("#hdnTipoRegistro").val();

register_module.controller('registerController', function ($scope, $http) {
    $scope.searchUser = function () {
        $http.get("/search/" + tipoRegistro + "/" + $scope.codigo_identificacion).then(function (response) {
            if (response.data.exist) {
                $scope.success = true;
                $scope.error = false;
                $scope.usuario = response.data.usuario;
                $scope.mensaje = response.data.mensaje;
            } else {
                $scope.error = true;
                $scope.success = false;
                $scope.mensaje = response.data.mensaje;
            }
        });
    };
});