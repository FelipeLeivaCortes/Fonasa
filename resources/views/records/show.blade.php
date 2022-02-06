@extends('adminlte::page')

@section('title', 'Detalles de la consulta')

@section('content_header')
    <h1>Consulta con más pacientes registrados</h1>
@stop

@section('content')
    @include('resources.alerts')

    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label>Hospital</label>
                <p class="form-control">{{$hospital->name}}</p>
            </div>

            <div class="form-group">
                <label>Profesional</label>
                <p class="form-control">{{$record->professional}}</p>
            </div>

            <div class="form-group">
                <label>Tipo de consulta</label>
                <p class="form-control">{{$record->type}}</p>
            </div>

            <div class="form-group">
                <label>Cantidad de pacientes</label>
                <p class="form-control">{{$record->patients}}</p>
            </div>

            <div class="form-group">
                <label>Estado Actual</label>
                <p class="form-control">{{$record->state}}</p>
            </div>
        </div>

        <div class="card-footer">
            <a href="{{route('admin.records.index')}}" class="btn btn-danger">Volver</a>
        </div>
    </div>
@stop