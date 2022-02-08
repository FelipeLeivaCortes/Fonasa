<?php

namespace App\Http\Controllers;

use App\Models\Adult;
use App\Models\Child;
use App\Models\Hospital;
use App\Models\Oldman;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $patients   = Patient::all();

        return view('patients.index',  compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $hospitals  = Hospital::all();
        return view('patients.create', compact('hospitals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'hospital_id'   => 'required',
            'name'          => ['required', 'string', 'regex:/^[a-zA-ZÑñ\s]+$/'],
            'age'           => ['required', 'regex:/^([1-9]{1}[0-9]{0,2})$/'],
        ]);

        // Child Category
        if ( $request->age >= 1 && $request->age <= 15 ) {
            $request->request->add(['category' => Patient::CHILD]);

            $patient    = Patient::create( $request->all() );

            Child::create([
                'patient_id'    => $patient->id,
                'relation'      => $request->weight - $request->height,
            ]);

        // Adult Category
        } else if ( $request->age >= 16 && $request->age <= 40 ) {
            $request->request->add(['category' => Patient::ADULT]);

            $patient    = Patient::create( $request->all() );
            $time       = $request->is_smoker ? $request->time : 0;

            Adult::create([
                'patient_id'    => $patient->id,
                'is_smoker'     => $request->is_smoker,
                'time'          => $time,
            ]);

        // Oldman Category
        } else {
            $request->request->add(['category' => Patient::OLDMAN]);

            $patient    = Patient::create( $request->all() );

            Oldman::create([
                'patient_id'    => $patient->id,
                'has_diet'      => $request->has_diet,
            ]);
        }

        return redirect()->route('admin.patients.index')->with('success', 'Se ha agregado el paciente exitosamente');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        $hospitals  = Hospital::all();
        $states     = [Patient::IN_LOBBY, Patient::AWAITING, Patient::ATTENDED];
        return view('patients.edit', compact('patient', 'hospitals', 'states'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'hospital_id'   => 'required',
            'name'          => ['required', 'string', 'regex:/^[a-zA-ZÑñ\s]+$/'],
            'age'           => ['required', 'regex:/^([1-9]{1}[0-9]{0,2})$/'],
        ]);

        // Child Category
        if ( $request->age >= 1 && $request->age <= 15 ) {
            $request->request->add(['category' => Patient::CHILD]);

            $patient->update( $request->all() );
            $patient->person->update([
                'relation'      => $request->weight - $request->height,
            ]);

        // Adult Category
        } else if ( $request->age >= 16 && $request->age <= 40 ) {
            $request->request->add(['category' => Patient::ADULT]);

            $patient->update( $request->all() );
            $time       = $request->is_smoker ? $request->time : 0;
            
            $patient->person->update([
                'is_smoker'     => $request->is_smoker,
                'time'          => $time,
            ]);

        // Oldman Category
        } else {
            $request->request->add(['category' => Patient::OLDMAN]);

            $patient->update( $request->all() );
            $patient->person->update([
                'has_diet'      => $request->has_diet,
            ]);

        }

        return redirect()->route('admin.patients.index')->with('success', 'Se han actualizado los datos del paciente exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('admin.patients.index')->with('success', 'Se ha eliminado el paciente exitosamente');
    }
}
