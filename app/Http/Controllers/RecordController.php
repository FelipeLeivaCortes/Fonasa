<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospitals  = Hospital::all();
        $records    = Record::all();
        return view('records.index', compact('hospitals', 'records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hospitals  = Hospital::all();
        $types      = [Record::TYPE_PEDIATRIA, Record::TYPE_URGENCIA, Record::TYPE_CGI];
        return view('records.create', compact('hospitals', 'types'));
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
            'professional'  => ['required', 'regex:/^[a-zA-ZÑñ\s]+$/'],
            'type'          => 'required|string',
        ]);

        Record::create($request->all());

        return redirect()->route('admin.records.index')->with('success', 'Se ha agregado la consulta exitosamente');
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
    public function edit(Record $record)
    {
        $hospitals  = Hospital::all();
        $types      = [Record::TYPE_PEDIATRIA, Record::TYPE_URGENCIA, Record::TYPE_CGI];
        $states     = [Record::STATE_AVAILABLE, Record::STATE_OCUPPED];

        return view('records.edit', compact('hospitals', 'types', 'states', 'record'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Record $record)
    {
        $request->validate([
            'hospital_id'   => 'required',
            'professional'  => ['required', 'regex:/^[a-zA-ZÑñ\s]+$/'],
            'type'          => 'required|string',
            'state'         => 'required|string',
        ]);

        $record->update($request->all());

        return redirect()->route('admin.records.index')->with('success', 'Se ha actualizado la consulta exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        $record->delete();
        return redirect()->route('admin.records.index')->with('success', 'Se ha eliminado la consulta exitosamente');
    }

    public function unlock()
    {
        $records    = Record::all()->where('state', Record::STATE_OCUPPED);

        foreach ( $records as $record ) {
            $record->update(['state' => Record::STATE_AVAILABLE]);
        }

        return redirect()->route('admin.records.index')->with('success', 'Se han liberado todas las consultas exitosamente');
    }

    public function max_patients(Request $request)
    {
        $hospital   = Hospital::find($request->hospital_id);
        $records    = $hospital->records;

        if ( sizeof($records) == 0 ) {
            return back()->with('error', 'No se han encontrado consultas asociadas al hospital '.$hospital->name);
        
        } else {
            $record = (object) array('patients' => 0);

            foreach ( $records as $element ) {
                if ( $element->patients > $record->patients ) {
                    $record = $element;
                }
            }

            return view('records.show', compact('record', 'hospital'));
        }
     }
}
