<div class="card-header">
    {!! Form::open(['route' => $url, 'method' => 'GET']) !!}
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

@section('js_custom')
    <script src="{{asset('js/lobby_controller.js')}}"></script>
@stop