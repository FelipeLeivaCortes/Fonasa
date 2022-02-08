
<div class="form-group">
    {!! Form::label('hospital_id', 'Hospital') !!}
    <select class="form-control" name="hospital_id" id="hospital_id">
        @foreach ($hospitals as $hospital)
            <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    {!! Form::label('name', 'Nombre') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese nombre completo del paciente']) !!}
</div>

<div class="form-group">
    {!! Form::label('age', 'Edad') !!}
    {!! Form::number('age', null, ['class' => 'form-control', 'placeholder' => 'Ingrese edad del paciente']) !!}
</div>

@isset($patient)
    {!! Form::label('state', 'Estado Actual') !!}
    <select class="form-control" name="state" id="state" required>
        <option value="" disabled selected>Seleccione un estado</option>
        @foreach ( $states as $state )
            <option value="{{ $state }}">{{ $state }}</option>
        @endforeach
    </select>

    <small>* Nota: Este campo sólo se incluye para comprobrar el reingreso del paciente a una nueva consulta</small>
@endisset

<!-- Child Container -->
<div class="d-none" id="child_container">
    <div class="form-group">
        {!! Form::label('weight', 'Peso') !!}
        {!! Form::text('weight', null, ['class' => 'form-control', 'placeholder' => 'Ingrese peso del paciente']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('height', 'Altura') !!}
        {!! Form::text('height', null, ['class' => 'form-control', 'placeholder' => 'Ingrese altura del paciente']) !!}
    </div>
</div>

<!-- Adult Container -->
<div class="d-none" id="adult_container">
    <div class="form-group">
        {!! Form::label('is_smoker', '¿Es Fumador?') !!}
        <select class="form-control" name="is_smoker" id="is_smoker">
            <option value="1">Si</option>
            <option value="0">No</option>
        </select>
    </div>

    <div class="form-group" id="time_container">
        {!! Form::label('time', 'Tiempo Fumando') !!}
        {!! Form::number('time', null, ['class' => 'form-control', 'placeholder' => 'Ingrese los años que el paciente lleva fumando']) !!}
    </div>
</div>

<!-- Oldman Container -->
<div class="d-none" id="oldman_container">
    <div class="form-group">
        {!! Form::label('has_diet', '¿Tiene Dieta Asignada?') !!}
        <select class="form-control" name="has_diet" id="has_diet">
            <option value="1">Si</option>
            <option value="0">No</option>
        </select>
    </div>
</div>

<script src="{{asset('js/patient.js')}}"></script>