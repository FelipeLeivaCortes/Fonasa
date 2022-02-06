@extends('adminlte::page')

@section('title', 'Hospitales')

@section('content_header')
    <h1>Sala de Espera</h1>
@stop

@section('content')
    @include('resources.alerts')

    @php
        if ( session('patients') ) {
            $patients   = session('patients');
        }
    @endphp

    <div class="card">
        <div class="card-header">
            {!! Form::open(['route' => 'admin.lobby.get_data']) !!}
                <div class="form-group">
                    <label for="hospital_id">Seleccione Hospital</label>
                    <div class="row">
            
                        <select class="form-control col-11 mr-2" name="hospital_id" id="hospital_id">
                            <option value="" disabled selected>Seleccione un hospital</option>

                            @foreach ($hospitals as $hospital)
                                <option value="{{$hospital->id}}">{{$hospital->name}}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-primary col" disabled id="btn_search"><i class="fas fa-search"></i> Buscar</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>

        <!-- It's necessary to check if exists patients recorded -->
        @php
            if  ( session('hospital') ) {
                $hospital   = session('hospital');
            }
        @endphp

        <div class="card-body {{ sizeof($patients) == 0 ? 'd-none' : '' }}">
            <button id="btn_attend" class="btn btn-danger mr-2 btn-sm">Atender</button>
            
            {!! Form::open(['route' => 'admin.lobby.critical_smokers']) !!}
            <input name="hospital_id" type="hidden" value="{{$hospital->id}}">
                {!! Form::submit('Fumadores Críticos', ['class' => 'btn btn-primary mr-2 btn-sm']) !!}
            {!! Form::close() !!}

            <button id="btn_oldest" class="btn btn-primary mr-2 btn-sm">Paciente más viejo</button>
            <button class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#riskiestPatientsModal">Pacientes mayor riesgo</button>
        </div>
    </div>

    <div class="card {{ sizeof($patients) == 0 ? 'd-none' : '' }}">
        <div class="card-header">
            <h4>Pacientes del hospital: {{$hospital->name}}</h4>
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Edad</th>
                        <th>Categoria</th>
                        <th>Prioridad</th>
                        <th>Riesgo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($patients as $patient)
                        <tr id="row_{{$patient->id}}">
                            <td>{{$patient->id}}</td>
                            <td>{{$patient->name}}</td>
                            <td>{{$patient->age}}</td>
                            <td>{{$patient->person::CATEGORY}}</td>
                            <td>{{$patient->priority}}</td>
                            <td>{{$patient->risk}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No se han encontrado pacientes registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Riskiest Patients Modal -->
    <div class="modal fade" id="riskiestPatientsModal" tabindex="-1" role="dialog" aria-labelledby="riskiestPatientsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            {!! Form::open(['route' => 'admin.lobby.riskiest_patients']) !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Filtrar pacientes de mayor riesgo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            {!! Form::label('no_clinical', 'Ingrese N° Historia clínica') !!}
                            {!! Form::number('no_clinical', null, ['class' => 'form-control']) !!}
                            <input name="hospital_id" type="hidden" value="{{$hospital->id}}">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        {!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

    <script src="{{asset('js/lobby_controller.js')}}"></script>
@stop