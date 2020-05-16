$(function () {

    ickeckRadioCheckbox();

    escuelasSelect2();

    escuelasAutoComplete();

    dependenciasSelect2();

    dependenciasAutoComplete();

    tiposActivoAutoComplete();

    marcasActivosAutoComplete();

    editorHtml5();

});


function ickeckRadioCheckbox() {
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-red',
        radioClass: 'iradio_flat-red'
    });
    //Squared red color scheme for iCheck
    $('input[type="checkbox"].square-red, input[type="radio"].square-red').iCheck({
        checkboxClass: 'icheckbox_square-red',
        radioClass: 'iradio_square-red'
    });
}

function escuelasSelect2() {

    let escuelaSelect2 = $(".select-escuela");

    if (escuelaSelect2.length) {
        escuelaSelect2.select2({
            language: "es",
            minimumInputLength: 2,
            ajax: {
                url: '/usuarios/escuelas/',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            },
            cache: true
        });
    }

}

function escuelasAutoComplete() {
    let arr = [];

    let escuela_typeahead = $('.escuela-typeahead');

    if (escuela_typeahead.length) {
        $.get("/usuarios/escuelas/", function (data) {

            for (let i = 0; i < data.length; i++) {
                arr.push(JSON.stringify(data[i]));
            }

            escuela_typeahead.typeahead({
                source: arr,
                highlighter: function (arr) {
                    return JSON.parse(arr).escuela;
                },
                matcher: function (arr) {
                    return JSON.parse(arr).escuela.toLocaleLowerCase().indexOf(this.query.toLocaleLowerCase()) != -1;
                },
                updater: function (arr) {
                    $('#hdnEscuela').val(JSON.parse(arr).escuela);
                    return JSON.parse(arr).escuela;
                }
            });

        }, 'json');
    }


}

function dependenciasSelect2() {

    let dependenciaSelect2 = $(".select-dependencia");

    if (dependenciaSelect2.length) {
        dependenciaSelect2.select2({
            language: "es",
            minimumInputLength: 2,
            ajax: {
                url: '/usuarios/dependencias/',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            },
            cache: true
        });
    }
}

function dependenciasAutoComplete() {
    let arr = [];

    let dependencia_typeahead = $('.dependencia-typeahead');

    if (dependencia_typeahead.length) {
        $.get("/usuarios/dependencias/", function (data) {

            for (let i = 0; i < data.length; i++) {
                arr.push(JSON.stringify(data[i]));
            }

            dependencia_typeahead.typeahead({
                source: arr,
                highlighter: function (arr) {
                    return JSON.parse(arr).dependencia;
                },
                matcher: function (arr) {
                    return JSON.parse(arr).dependencia.toLocaleLowerCase().indexOf(this.query.toLocaleLowerCase()) != -1;
                },
                updater: function (arr) {
                    $('#hdnDependencia').val(JSON.parse(arr).dependencia);
                    return JSON.parse(arr).dependencia;
                }
            });

        }, 'json');
    }
}


function tiposActivoAutoComplete() {

    let arr = [];

    let tipos_activos = $('.tipos-activos-typeahead');

    if (tipos_activos.length) {
        $.get("/activos/tipos/", function (data) {

            for (let i = 0; i < data.length; i++) {
                arr.push(JSON.stringify(data[i]));
            }

            tipos_activos.typeahead({
                source: arr,
                highlighter: function (arr) {
                    return JSON.parse(arr).tipo;
                },
                matcher: function (arr) {
                    return JSON.parse(arr).tipo.toLocaleLowerCase().indexOf(this.query.toLocaleLowerCase()) != -1;
                },
                updater: function (arr) {
                    return JSON.parse(arr).tipo;
                }
            });

        }, 'json');
    }
}


function marcasActivosAutoComplete() {

    let arr = [];

    let activos_marcas = $('.marcas-activos-typeahead');

    if (activos_marcas.length) {
        $.get("/activos/marcas/", function (data) {

            for (let i = 0; i < data.length; i++) {
                arr.push(JSON.stringify(data[i]));
            }

            activos_marcas.typeahead({
                source: arr,
                highlighter: function (arr) {
                    return JSON.parse(arr).marca;
                },
                matcher: function (arr) {
                    return JSON.parse(arr).marca.toLocaleLowerCase().indexOf(this.query.toLocaleLowerCase()) != -1;
                },
                updater: function (arr) {
                    return JSON.parse(arr).marca;
                }
            });

        }, 'json');
    }
}

function editorHtml5() {

    if ($("#compose-textarea").length) {
        $("#compose-textarea").wysihtml5();
    }

}