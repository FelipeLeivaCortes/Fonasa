<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LobbyController extends Controller
{
    public function index()
    {
        $childs = $adults = $oldmans = array();
        $patients   = Patient::all();
        $records    = Record::all()->where('state', Record::STATE_AWAITING);

        return view('lobby.index', compact('patients', 'records'));
    }

    public function oldest()
    {
        $patients    = Patient::orderBy('age', 'desc')->take(1)->get();

        return back()->with('patients', $patients);
    }

    public function get_childs()
    {
        $patients   = Patient::all()->where('category', Patient::CHILD);

        return back()->with('patients', $patients);
    }

    public function critical_smokers()
    {
        $smokers    = DB::table('adults')->select('patient_id')->where('is_smoker', 1)->get();
        $patients   = array();

        foreach ( $smokers as $smoker ) {
            $patient    = Patient::find( $smoker->patient_id );

            if ( sizeof($patients) == 0 ) {
                array_push( $patients, $patient );
            
            } else {
                for ($i=0; $i < sizeof($patients); $i++) {
                    if ( $patient->priority() > $patients[$i]->priority() ) {
                         

                    }

                }
            }
        }

        return $patients;
    }
}
