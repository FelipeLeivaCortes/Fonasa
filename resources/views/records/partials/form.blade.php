
<div class="form-group">
    {!! Form::label('hospital_id', 'Hospital') !!}
    <select class="form-control" name="hospital_id" id="hospital_id">
        @foreach ( $hospitals as $hospital )
            <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    {!! Form::label('professional', 'Especialista') !!}
    {!! Form::text('professional', null, ['class' => 'form-control', 'placeholder' => 'Ingrese nombre del especialista']) !!}
</div>

<div class="form-group">
    {!! Form::label('type', 'Tipo de consulta') !!}
    <select class="form-control" name="type" id="type">
        @foreach ( $types as $type )
            <option value="{{ $type }}">{{ $type }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <small>* Nota: Tenga en consideración que, por defecto, una consulta nueva tendrá la cantidad de pacientes en "0" y el estado "Espera"</small>
</div>