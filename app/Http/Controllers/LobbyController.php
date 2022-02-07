<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\Patient;
use App\Models\Record;
use Illuminate\Http\Request;

class LobbyController extends Controller
{
    public function index()
    {
        $patients   = [];
        $hospitals  = Hospital::all();

        return view('lobby.index', compact('patients', 'hospitals'));
    }

    public function get_data(Request $request)
    {
        $hospital   = Hospital::find($request->hospital_id);
        $unsorted   = $hospital->patients->where('state', Patient::IN_LOBBY);

        if ( sizeof($unsorted) == 0 ) {
            return back()->with('info', 'No se han encontrado pacientes registrados en el hospital '.$hospital->name);
        
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

    public function critical_smokers(Request $request)
    {
        $hospital   = Hospital::find($request->hospital_id);
        $adults     = $hospital->patients->where('state', Patient::IN_LOBBY)->where('category', Patient::ADULT);

        if ( sizeof($adults) == 0 ) {
            return back()->with('error', 'No se han encontrado pacientes adultos registrados en el hospital '.$hospital->name);
        
        } else {
            $unsorted   = array();

            foreach ($adults as $adult) {
                if ( $adult->person->is_smoker ) {
                    array_push($unsorted, $adult);
                }
            }

            $patients   = array();
            $stack      = array();

            foreach ( $unsorted as $patient ) {
                $patient->priority  = round($patient->priority(), 3);
                $patient->risk      = round($patient->risk(), 3);

                $limit      = sizeof($patients);
                $counter    = 0;

                for ($i = $limit - 1; $i >= 0; $i-- ) {
                    if ( $patient->risk > $patients[$i]->risk ) {
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

            if ( sizeof($patients) == 0 ) {
                return back()->with('info', 'No se han encontrado pacientes fumadores registrados en el hospital '.$hospital->name);
            
            } else {
                return back()->with('patients', $patients)
                            ->with('hospital', $hospital);

            }
        }
    }

    public function riskiest_patients(Request $request)
    {
        $hospital   = Hospital::find($request->hospital_id);
        $unsorted   = $hospital->patients->where('state', Patient::IN_LOBBY)->where('noHistoriaClinica', '>=', $request->no_clinical);
    
        $patients   = array();
        $stack      = array();

        foreach ( $unsorted as $patient ) {
            $patient->priority  = round($patient->priority(), 3);
            $patient->risk      = round($patient->risk(), 3);

            $limit      = sizeof($patients);
            $counter    = 0;

            for ($i = $limit - 1; $i >= 0; $i-- ) {
                if ( $patient->risk > $patients[$i]->risk ) {
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

        if ( sizeof($patients) == 0 ) {
            return back()->with('info', 'No se han encontrado pacientes con un historial clínico superior a '.$request->no_clinical);

        } else {
            return back()->with('patients', $patients)
                    ->with('hospital', $hospital);

        }
    }

    public function optimize_attendance(Request $request)
    {
        $hospital   = Hospital::find($request->hospital_id);
        $unsorted   = $hospital->patients->where('state', Patient::IN_LOBBY)->where('category', Patient::CHILD);
        $children   = array();
        $stack      = array();

        /**
         * Sorting the children by higher risk
         */
        foreach ( $unsorted as $child ) {
            $child->priority  = round($child->priority(), 3);
            $child->risk      = round($child->risk(), 3);

            $limit      = sizeof($children);
            $counter    = 0;

            for ($i = $limit - 1; $i >= 0; $i-- ) {
                if ( $child->risk > $children[$i]->risk ) {
                    array_push($stack, array_pop($children));
                    $counter++;

                } else {
                    break;
                    
                }
            }

            array_push($children, $child);

            for ($j=0; $j < $counter; $j++) { 
                array_push($children, array_pop($stack) );
            }
        }

        $unsorted   = $hospital->patients->where('state', Patient::IN_LOBBY)->where('category', Patient::OLDMAN);
        $oldmen     = array();
        $stack      = array();

        /**
         * Sorting the oldmen by higher priority
         */
        foreach ( $unsorted as $oldman ) {
            $oldman->priority  = round($oldman->priority(), 3);
            $oldman->risk      = round($oldman->risk(), 3);

            $limit      = sizeof($oldmen);
            $counter    = 0;

            for ($i = $limit - 1; $i >= 0; $i-- ) {
                if ( $oldman->risk > $oldmen[$i]->risk ) {
                    array_push($stack, array_pop($oldmen));
                    $counter++;

                } else {
                    break;
                    
                }
            }

            array_push($oldmen, $oldman);

            for ($j=0; $j < $counter; $j++) { 
                array_push($oldmen, array_pop($stack) );
            }
        }

        $unsorted   = $hospital->patients->where('state', Patient::IN_LOBBY)->where('category', Patient::ADULT);
        $adults     = array();
        $stack      = array();

        /**
         * Sorting the adults by higher priority
         */
        foreach ( $unsorted as $adult ) {
            $adult->priority  = round($adult->priority(), 3);
            $adult->risk      = round($adult->risk(), 3);

            $limit      = sizeof($adults);
            $counter    = 0;

            for ($i = $limit - 1; $i >= 0; $i-- ) {
                if ( $adult->risk > $adults[$i]->risk ) {
                    array_push($stack, array_pop($adults));
                    $counter++;

                } else {
                    break;
                    
                }
            }

            array_push($adults, $adult);

            for ($j=0; $j < $counter; $j++) { 
                array_push($adults, array_pop($stack) );
            }
        }

        return back()->with('patients', array_merge($children, $oldmen, $adults))
                    ->with('hospital', $hospital);
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

        if ( sizeof($data['records']) == 0 ) {
            $patient->update([
                'state' => Patient::AWAITING,
            ]);
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

        return redirect()->route('admin.lobby.index')->with('success', 'Se ha registrado el paciente con consulta exitosamente');
    }
}
