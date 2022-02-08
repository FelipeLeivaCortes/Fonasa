@extends('adminlte::page')

@section('title', 'Agregar Hospital')

@section('content_header')
    <h1>Agregar Hospital</h1>
@stop

@section('content')
    @include('resources.alerts')

    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'admin.hospitals.store']) !!}

                @include('hospitals.partials.form')

                <div class="d-flex justify-content-center mt-5">
                    <button type="submit" class="btn btn-primary mr-2">Agregar</button>
                    <a href="{{route('admin.hospitals.index')}}" class="btn btn-danger">Volver</a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop