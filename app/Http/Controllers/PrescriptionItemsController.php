<?php

namespace App\Http\Controllers;

use App\Models\PrescriptionItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PrescriptionItemsController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PrescriptionItems $prescriptionItems)
    {
        //
    }

    public function getItems($prescription_id){
        // dd($prescription_id);
        $prescriptionItems = PrescriptionItems::where('prescription_id',$prescription_id)
        ->with('drugs')->with('prescription')->get();
        return $prescriptionItems;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrescriptionItems $prescriptionItems)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrescriptionItems $prescriptionItems)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrescriptionItems $prescriptionItems)
    {
        //
    }
}
