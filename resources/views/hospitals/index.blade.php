@extends('adminlte::page')

@section('title', 'Hospitales Registrados')

@section('content_header')
    <h1>Hospitales Registrados</h1>
@stop

@section('content')
    @include('resources.alerts')

    <div class="card">
        <div class="card-header">
            <a href="{{route('admin.hospitals.create')}}" class="btn btn-primary btn-sm">Agregar Hospital</a>
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
                                <a href="{{route('admin.hospitals.edit', $hospital)}}" class="btn btn-info btn-sm">Editar</a>
                            </td>
                            <td width="10px">
                                {!! Form::open(['route' => ['admin.hospitals.destroy', $hospital], 'class' => 'delete_hospital']) !!}
                                @method('delete')
                                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger btn-sm']) !!}
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

@section('js_custom')
    <script src="{{asset('js/confirm_actions.js')}}"></script>
@stop