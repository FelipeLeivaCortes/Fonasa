@extends('adminlte::page')

@section('title', 'Pacientes')

@section('content_header')
    <h1>Lista de pacientes</h1>
@stop

@section('content')
    @include('resources.alerts')

    <div class="card">
        <div class="card-header">
            <a href="{{route('admin.patients.create')}}" class="btn btn-primary"><i class="fas fa-user-plus"></i> Registrar Paciente</a>
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Edad</th>
                        <th colspan="3">Hospital</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($patients as $patient)
                        <tr>
                            <td>{{$patient->id}}</td>
                            <td>{{$patient->name}}</td>
                            <td>{{$patient->age}}</td>
                            <td>{{$patient->hospital->name}}</td>

                            <td width="10px">
                                <a href="{{route('admin.patients.edit', $patient)}}" class="btn btn-info btn-sm">Editar</a>
                            </td>
                            <td width="10px">
                                {!! Form::open(['route' => ['admin.patients.destroy', $patient]]) !!}
                                @method('delete')
                                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No se han encontrado pacientes registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
@stop