@extends('adminlte::page')

@section('title', 'Hospitales')

@section('content_header')
    <h1>Sala de Espera</h1>
@stop

@section('content')
    @include('resources.alerts')

    <div class="card">
        <div class="card-header">
            <a href="{{route('admin.lobby.critical_smokers')}}" class="btn btn-primary mr-2"><i class="fas fa-smoking"></i> Ver Fumadores Críticos</a>
            
            <a href="{{route('admin.lobby.oldest')}}" class="btn btn-primary mr-2"><i class="fas fa-male"></i> Paciente más anciano</a>
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th colspan="2">Edad</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        if  ( session('patients') ) {
                            $patients   = session('patients');
                        }
                    @endphp

                    @forelse ($patients as $patient)
                        <tr>
                            <td>{{$patient->id}}</td>
                            <td>{{$patient->name}}</td>
                            <td>{{$patient->age}}</td>
                            <td width="15px">
                                <button class="btn btn-info btn-sm">Atender</button>
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