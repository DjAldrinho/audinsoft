<h4>Datos de reserva</h4>
<div class="form-group has-feedback{{ $errors->has('fecha_actual') ? ' has-error' : '' }}">
    <label for="id" class="col-md-4 control-label">Fecha Actual</label>
    <div class="col-md-6">
        <input class="form-control" value="{{old('fecha_actual')}}" name="fecha_actual"
               ng-model="reserva.fecha_actual" locale="es" readonly>
        @if ($errors->has('fecha_actual'))
            <span class="help-block">
                    <strong>{{ $errors->first('fecha_actual') }}</strong>
                </span>
        @endif
    </div>
</div>
<div class="form-group has-feedback{{ $errors->has('fecha_reserva') ? ' has-error' : '' }}">
    <label for="id" class="col-md-4 control-label">Fecha de reserva</label>
    <div class="col-md-6">
        <input class="form-control"
               value="{{old('fecha_reserva')}}"
               moment-picker="reserva.fecha_reserva" format="DD/MM/YYYY"
               placeholder="Fecha de la reserva"
               locale="es"
               start-view="month"
               min-date="minDateReserva"
               ng-model="reserva.fecha_reserva"
               ng-model-options="{ updateOn: 'blur' }"
               required
               name="fecha_reserva">
        @if ($errors->has('fecha_reserva'))
            <span class="help-block">
                    <strong>{{ $errors->first('fecha_reserva') }}</strong>
                </span>
        @endif
    </div>
</div>
<div class="form-group has-feedback{{ $errors->has('hora_inicio') ? ' has-error' : '' }}">
    <label for="id" class="col-md-4 control-label">Hora de inicio</label>
    <div class="col-md-6">
        <input class="form-control"
               value="{{old('hora_inicio')}}"
               moment-picker="reserva.hora_inicio" format="hh:00 a"
               min-date="minHoraInicioReserva"
               max-date="maxHoraInicioReserva"
               placeholder="Hora de inicio"
               ng-model="reserva.hora_inicio"
               ng-model-options="{ updateOn: 'blur' }"
               change="updateHoraFinal(value, newValue)"
               name="hora_inicio"
               required>
        @if($errors->has('hora_inicio'))
            <span class="help-block">
                    <strong>{{ $errors->first('hora_inicio') }}</strong>
                </span>
        @endif
    </div>
</div>
<div class="form-group has-feedback{{ $errors->has('hora_final') ? ' has-error' : '' }}">
    <label for="id" class="col-md-4 control-label">Hora Final</label>
    <div class="col-md-6">
        <input class="form-control"
               value="{{old('hora_final')}}"
               ng-model="reserva.hora_final"
               placeholder="Hora final"
               readonly
               name="hora_final"
               required>
        @if($errors->has('hora_final'))
            <span class="help-block">
                    <strong>{{ $errors->first('hora_final') }}</strong>
                </span>
        @endif
    </div>
</div>
<hr>