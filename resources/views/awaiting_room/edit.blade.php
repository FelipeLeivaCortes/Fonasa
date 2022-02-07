@extends('adminlte::page')

@section('title', 'Actualizar Hospital')

@section('content_header')
    <h1>Actualizar Datos</h1>
@stop

@section('content')
    @include('resources.alerts')

    <div class="card">
        <div class="card-body">
            {!! Form::model($hospital, ['route' => ['admin.hospitals.update', $hospital], 'method' => 'put']) !!}
                @include('hospitals.partials.form')

                <div class="d-flex justify-content-center mt-5">
                    <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-edit"></i> Actualizar Datos</button>
                    <a href="{{route('admin.hospitals.index')}}" class="btn btn-danger">Volver</a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop