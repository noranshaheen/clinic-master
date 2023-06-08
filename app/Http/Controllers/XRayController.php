<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\XRay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class XRayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $analysis = new XRay();
        $analysis->name = $request->name;
        $analysis->description = $request->description;
        $analysis->specialty_id = $request->specialty_id;
        $analysis->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, XRay $xray)
    {
        $data = $request->validate([
            'name' => ['string','max:255','min:2','required','regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'description' => ['string','max:255','min:2','required','regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'specialty_id' => ['required']
        ]);
        $xray->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function allSpeciatlyRays(){
        $doc = Doctor::find(Auth::user()->doc_res_id);
        $specialty_id = $doc->specialty_id;
        return XRay::where('specialty_id','=',$specialty_id)->get();
    }
}
