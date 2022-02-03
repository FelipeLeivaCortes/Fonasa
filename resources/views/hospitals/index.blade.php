@extends('adminlte::page')

@section('title', 'Hospitales')

@section('content_header')
    <h1>Lista de hospitales</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">

        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th colspan="3">Dirección</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($hospitals as $hospital)
                        <tr>
                            <td>{{$hospital->id}}</td>
                            <td>{{$hospital->name}}</td>
                            <td>{{$hospital->direction}}</td>
                            <td width="10px">
                                <a href="{{route('admin.hospitals.edit', $hospital)}}" class="btn btn-info">Editar</a>
                            </td>
                            <td width="10px">
                                {!! Form::open(['route' => ['admin.hospitals.destroy', $hospital]]) !!}
                                @method('delete')
                                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No se han encontrado hospitales registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
@stop