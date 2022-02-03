@extends('adminlte::page')

@section('title', 'Actualizar Usuario')

@section('content_header')
    <h1>Actualizar Datos</h1>
@stop

@section('content')
    @include('resources.alerts')

    <div class="card">
        <div class="card-body">
            {!! Form::model($user, ['route' => ['admin.users.update', $user], 'method' => 'put']) !!}
                @include('admin.users.partials.form')

                <div class="d-flex justify-content-center mt-5">
                    <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-user-edit"></i> Actualizar Datos</button>
                    <a href="{{route('admin.users.index')}}" class="btn btn-danger">Volver</a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop