<h4>Datos de usuario</h4>
<div class="form-group">
    <label for="id" class="col-md-4 control-label">Nombre</label>
    <div class="col-md-6">
        <input type="text" class="form-control" value="{{Auth::user()->nombreCompleto}}" disabled>
    </div>
</div>
<div class="form-group">
    <label for="id" class="col-md-4 control-label">Identificacion</label>
    <div class="col-md-6">
        <input type="text" class="form-control" value="{{Auth::user()->identificacion}}" disabled>
    </div>
</div>
@if(Auth::user()->rol == 'Administrativo' || Auth::user()->rol == 'Docente')
    <div class="form-group">
        <label for="id" class="col-md-4 control-label">Dependencia</label>
        <div class="col-md-6">
            <input type="text" class="form-control" value="{{Auth::user()->dependencia}}" disabled>
        </div>
    </div>
@endif
@if(Auth::user()->rol == 'Estudiante' || Auth::user()->rol == 'Egresado')
    <div class="form-group">
        <label for="id" class="col-md-4 control-label">Escuela</label>
        <div class="col-md-6">
            <input type="text" class="form-control" value="{{Auth::user()->escuela}}" disabled>
        </div>
    </div>
    <div class="form-group">
        <label for="id" class="col-md-4 control-label">Codigo</label>
        <div class="col-md-6">
            <input type="text" class="form-control" value="{{isset(Auth::user()->codigo_usuario)?Auth::user()->codigo_usuario:'NA'}}" disabled>
        </div>
    </div>
@endif
<div class="form-group">
    <label for="id" class="col-md-4 control-label">Tipo</label>
    <div class="col-md-6">
        <input type="text" class="form-control" value="{{Auth::user()->rol}}" disabled>
    </div>
</div>
<hr>