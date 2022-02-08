<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\Patient;
use App\Models\Record;
use Illuminate\Http\Request;

class AwaitingRoomController extends Controller
{
    public function index()
    {
        $patients   = [];
        $hospitals  = Hospital::all();

        return view('awaiting_room.index', compact('patients', 'hospitals'));
    }

    public function get_data(Request $request)
    {
        $hospital   = Hospital::find($request->hospital_id);
        $unsorted   = $hospital->patients->where('state', Patient::AWAITING);

        if ( sizeof($unsorted) == 0 ) {
            return back()->with('info', 'No se han encontrado pacientes en la sala de espera del hospital '.$hospital->name);
        
        } else {
            $patients   = array();
            $stack      = array();

            foreach ( $unsorted as $patient ) {
                $patient->priority  = round($patient->priority(), 3);
                $patient->risk      = round($patient->risk(), 3);

                $limit      = sizeof($patients);
                $counter    = 0;

                for ($i = $limit - 1; $i >= 0; $i-- ) {
                    if ( $patient->priority > $patients[$i]->priority ) {
                        array_push($stack, array_pop($patients));
                        $counter++;

                    } else {
                        break;
                        
                    }
                }

                array_push($patients, $patient);

                for ($j=0; $j < $counter; $j++) { 
                    array_push($patients, array_pop($stack) );
                }
            }

            return back()->with('patients', $patients)
                        ->with('hospital', $hospital);
        }
    }

    public function get_records(Request $request)
    {
        $data       = array();
        $hospital   = Hospital::find($request->hospital_id);
        $patient    = Patient::find($request->patient_id);

        if ( $patient->priority() <= 4 ) {
            switch ( $patient->category ) {
                case Patient::CHILD:
                    $data['records']    = $hospital->records->where('type', Record::TYPE_PEDIATRIA)->where('state', Record::STATE_AVAILABLE);
                    $data['type']       = Record::TYPE_PEDIATRIA;
                    break;

                case Patient::ADULT:
                case Patient::OLDMAN:
                    $data['records']    = $hospital->records->where('type', Record::TYPE_CGI)->where('state', Record::STATE_AVAILABLE);
                    $data['type']       = Record::TYPE_CGI;
                    break;

            }

        } else {
            $data['records']    = $hospital->records->where('type', Record::TYPE_URGENCIA)->where('state', Record::STATE_AVAILABLE);
            $data['type']       = Record::TYPE_URGENCIA;

        }

        return $data;
    }

    public function attend_patient(Request $request)
    {
        $patient    = Patient::find($request->patient_id);
        $patient->update([
            'state'     => Patient::ATTENDED,
        ]);

        $record = Record::find($request->record_id);
        $record->update([
            'state'     => Record::STATE_OCUPPED,
            'patients'  => ($record->patients + 1),
        ]);

        return redirect()->route('admin.awaiting_room.index')->with('success', 'El paciente ha sido recepcionado por el profesional exitosamente');
    }
}
