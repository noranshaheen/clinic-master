<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use App\Models\Diagnosis;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;


class AnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
        $analysis = new Analysis();
        $analysis->name = $request->name;
        $analysis->description = $request->description;
        $analysis->specialty_id = $request->specialty_id;
        $analysis->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Analysis $analysis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Analysis $analysis)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Analysis $analysis)
    {
        $data = $request->validate([
            'name' => ['string','max:255','min:2','required','regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'description' => ['string','max:255','min:2','required','regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'specialty_id' => ['required']
        ]);
        $analysis->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Analysis $analysis)
    {
        $analysis->delete();
    }

    public function allSpeciatlyAnalysis(){
        $doc = Doctor::find(Auth::user()->doc_res_id);
        $specialty_id = $doc->specialty_id;
        return Analysis::where('specialty_id','=',$specialty_id)->get();
    }
    // public function all(){
    //     return Diagnosis::with('drugs')->get();
    // }
}
