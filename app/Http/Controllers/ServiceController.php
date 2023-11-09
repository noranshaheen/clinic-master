<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doc = Doctor::find(Auth::user()->doc_res_id);
        $specialty_id = $doc->specialty_id;
        return Service::where('specialty_id', '=', $specialty_id)->get();
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
        $request->validate([
            'name' => ['string','max:255','min:2','required'],
            'price' => ['string','max:255','min:2','nullable'],
            'specialty_id' => ['required','exists:App\Models\Specialty,id']
        ]);

        $analysis = new Service();
        $analysis->name = $request->name;
        $analysis->default_price = $request->price;
        $analysis->specialty_id = $request->specialty_id;
        $analysis->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        //
    }
}
