<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\Patient;
use Illuminate\Http\Request;

class LobbyController extends Controller
{
    public function index()
    {
        $patients   = [];
        $records    = [];
        $hospitals  = Hospital::all();

        return view('lobby.index', compact('patients', 'hospitals', 'records'));
    }

    public function get_data(Request $request)
    {
        $hospital   = Hospital::find($request->hospital_id);
        $unsorted   = $hospital->patients;
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

    public function critical_smokers(Request $request)
    {

        $hospital   = Hospital::find($request->hospital_id);
        $adults     = $hospital->patients->where('category', Patient::ADULT);
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

        return back()->with('patients', $patients)
                    ->with('hospital', $hospital);
    }

    public function riskiest_patients(Request $request)
    {
        $hospital   = Hospital::find($request->hospital_id);
        $unsorted   = $hospital->patients->where('noHistoriaClinica', '>=', $request->no_clinical);
    
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

    public function attend_patient(Request $request)
    {
        return $request;
    }
}
