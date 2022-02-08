@extends('adminlte::page')

@section('title', 'Sala de Espera')

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
            {!! Form::open(['route' => 'admin.awaiting_room.get_data']) !!}
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
            <div class="d-flex flex-row">
                <div>
                    <button id="btn_attend" class="btn btn-primary btn-sm mr-2" onclick="attend_pending_patients({{$hospital->id}})">Atender Paciente</button>
                </div>
            </div>

            <small>* Nota: Toda atención considera al primer paciente de la lista</small>
        </div>
    </div>

    <!-- Main -->
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
                        <tr id="row_{{$patient->id}}" class="waiting">
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

    <!-- Attend Patient Modal -->
    <div class="modal fade" id="attendPatientModal" tabindex="-1" role="dialog" aria-labelledby="attendPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">

            {!! Form::open(['route' => 'admin.awaiting_room.attend_patient']) !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Datos del paciente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input name="patient_id" id="patient_id" type="hidden">

                        <div class="form-group">
                            <label for="patient_name">Nombre</label>
                            <p class="form-control" id="patient_name"></p>                       
                        </div>

                        <div class="form-group">
                            <label for="patient_age">Edad</label>
                            <p class="form-control" id="patient_age"></p>                       
                        </div>

                        <div class="form-group">
                            <label for="patient_category">Categoria</label>
                            <p class="form-control" id="patient_category"></p>                       
                        </div>
                        
                        <div class="form-group">
                            <label for="patient_priority">Prioridad</label>
                            <p class="form-control" id="patient_priority"></p>                       
                        </div>

                        <div class="form-group">
                            <label for="patient_risk">Riesgo</label>
                            <p class="form-control" id="patient_risk"></p>                       
                        </div>

                        <div class="form-group">
                            <label for="record_type">Tipo Consulta</label>
                            <p class="form-control" id="record_type"></p>                       
                        </div>

                        <div class="form-group">
                            <label for="record_id">Profesional</label>
                            <select name="record_id" id="record_id" class="form-control" required>
                                <option value="" disabled selected>Seleccione una consulta</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        {!! Form::submit('Atender', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('js_custom')
    <script src="{{asset('js/lobby_controller.js')}}"></script>
@endsection