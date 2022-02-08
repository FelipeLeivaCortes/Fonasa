@extends('adminlte::page')

@section('title', 'Agregar Consulta')

@section('content_header')
    <h1>Agregar Consulta</h1>
@stop

@section('content')
    @include('resources.alerts')

    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'admin.records.store']) !!}

                @include('records.partials.form')

                <div class="d-flex justify-content-center mt-5">
                    <button type="submit" class="btn btn-primary mr-2">Agregar</button>
                    <a href="{{route('admin.records.index')}}" class="btn btn-danger">Volver</a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop