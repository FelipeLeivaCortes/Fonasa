@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Agregar Paciente</h1>
@stop

@section('content')
    @include('resources.alerts')

    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'admin.patients.store']) !!}

                @include('patients.partials.form')

                <div class="d-flex justify-content-center mt-5">
                    <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-user-plus"></i> Agregar Usuario</button>
                    <a href="{{route('admin.patients.index')}}" class="btn btn-danger">Volver</a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop