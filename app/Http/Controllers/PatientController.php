<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
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
    public function index()
    {
        $patients   = Patient::all();
        return view('patients.index',  compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

        # Child Category
        if ( $request->age >= 1 && $request->age <= 15 ) {
            $request->request->add(['category' => Patient::CHILD]);

            $patient    = Patient::create( $request->all() );
            $relation   = $request->weight - $request->height;

            DB::insert('insert into childrens (patient_id, relation) values (?, ?)', [$patient->id, $relation]);

        # Adult Category
        } else if ( $request->age >= 16 && $request->age <= 40 ) {
            $request->request->add(['category' => Patient::ADULT]);

            $patient    = Patient::create( $request->all() );
            $time       = $request->time == null ? 0 : $request->time;

            DB::insert('insert into adults (patient_id, is_smoker, time) values (?, ?, ?)',
                        [$patient->id, $request->is_smoker, $time]
            );

        # Oldman Category
        } else {
            $request->request->add(['category' => Patient::OLDMAN]);

            $patient    = Patient::create( $request->all() );

            DB::insert('insert into oldmans (patient_id, has_diet) values (?, ?)',
                        [$patient->id, $request->has_diet]
            );

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
    public function edit($id)
    {
        return 'Edit Patient '.$id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return 'Destroy Patient '. $id;
    }

    public function critical_patients()
    {
        return 'OK';
    }
}
