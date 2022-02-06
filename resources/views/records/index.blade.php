@extends('adminlte::page')

@section('title', 'Consultas')

@section('content_header')
    <h1>Consultas Registradas</h1>
@stop

@section('content')
    @include('resources.alerts')

    <div class="card">
        <div class="card-header">
            <a href="{{route('admin.records.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Registrar Consulta</a>
            <a href="{{route('admin.records.unlock')}}" class="btn btn-primary"><i class="fas fa-unlock"></i> Liberar Consultas</a>
            <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#maxPatientsModal"><i class="fas fa-search"></i> Consulta con más pacientes</button>
        </div>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hospital</th>
                        <th>Cant. Pacientes</th>
                        <th>Especialista</th>
                        <th>Estado</th>
                        <th colspan="3">Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $record)
                        <tr>
                            <td>{{$record->id}}</td>
                            <td>{{$record->hospital->name}}</td>
                            <td>{{$record->patients}}</td>
                            <td>{{$record->professional}}</td>
                            <td>{{$record->type}}</td>
                            <td>{{$record->state}}</td>
                            <td width="10px">
                                <a href="{{route('admin.records.edit', $record)}}" class="btn btn-info btn-sm">Editar</a>
                            </td>
                            <td width="10px">
                                {!! Form::open(['route' => ['admin.records.destroy', $record], 'class' => 'confirm_action']) !!}
                                @method('delete')
                                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No se han encontrado consultas registradas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Max Patients Modal -->
    <div class="modal fade" id="maxPatientsModal" tabindex="-1" role="dialog" aria-labelledby="maxPatientsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            {!! Form::open(['route' => 'admin.records.max_patients']) !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Filtrar consultas con más pacientes atendidos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            {!! Form::label('hospital_id', 'Seleccione un hospital') !!}
                            <select name="hospital_id" id="hospital_id" class="form-control">
                                <option value="" disabled selected>Seleccione un hospital</option>
                                @foreach ($hospitals as $hospital)
                                    <option value="{{$hospital->id}}">{{$hospital->name}}</option>
                                @endforeach
                            </select>
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
@stop

@section('js')
    <script src="{{asset('js/confirm_action.js')}}"></script>
@stop