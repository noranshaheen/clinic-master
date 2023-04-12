<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;

class ClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clinics = QueryBuilder::for(Clinic::class)
        ->defaultSort('id')
        ->allowedSorts(['id','name','phone','address'])
        ->allowedFilters(['name','phone','address'])
        ->paginate(Request()->input('perPage', 20))
        ->withQueryString();

        return Inertia::render('Clinics/Index', [
            'clinics' => $clinics
        ])->table(function (InertiaTable $table) {
            $table->column(
                key:"id",
                label:"ID",
                canBeHidden:true,
                hidden:false,
                sortable:true
            )->column(
                key:"name",
                label:"Name",
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"phone",
                label:"Phone",
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"address",
                label:"Address",
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"actions",
                label:"Actions",
            );
        });
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
            'name' => ['required','string','max:255'],
            'phone'=> ['required','string','max:100'],
            'address' =>['required','string','max:255'],
        ]);

        $clinic = new Clinic();
        $clinic->name = $request->name;
        $clinic->phone = $request->phone;
        $clinic->address = $request->address;
        $clinic->save();

        return redirect()->back();

    }

    /**
     * Display the specified resource.
     */
    public function show(Clinic $clinic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clinic $clinic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clinic $clinic)
    {
        $date = $request->validate([
            'name' => ['required','string','max:255'],
            'phone'=> ['required','string','max:100'],
            'city' =>['required','string','max:255'],
        ]);

        $clinic->update($date);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clinic $clinic)
    {
        $clinic->delete();
    }


    public function all(){
        $clinics = Clinic::all();
        return $clinics;
    }
}
