<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospitals  = Hospital::all();
        return view('hospitals.index', compact('hospitals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hospitals.create');
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
            'name'      => ['required', 'regex:/^[a-zA-ZÑñ\s]+$/'],
            'direction' => ['required', 'regex:/^[a-zA-ZÑñ\s]+$/'],
        ]);

        Hospital::create($request->all());

        return redirect()->route('admin.hospitals.index')->with('success', 'Se ha agregado el hospital exitosamente');
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
    public function edit(Hospital $hospital)
    {
        return view('hospitals.edit', compact('hospital'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hospital $hospital)
    {
        $request->validate([
            'name'      => ['required', 'regex:/^[a-zA-ZÑñ\s]+$/'],
            'direction' => ['required', 'regex:/^[a-zA-ZÑñ\s]+$/'],
        ]);

        $hospital->update($request->all());

        return redirect()->route('admin.hospitals.index')->with('success', 'Se han actualizado los datos hospital exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hospital $hospital)
    {
        $hospital->delete();
        return redirect()->route('admin.hospitals.index')->with('success', 'Se ha eliminado el hospital exitosamente');
    }
}
