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
        $records    = Record::all();
        return view('records.index', compact('records'));
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

        return view('records.edit', compact('hospitals', 'types', 'record'));
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
            $record->update(['state' => Record::STATE_AWAITING]);
        }

        return redirect()->route('admin.records.index')->with('success', 'Se han libeado todas las consultas exitosamente');
    }
}
