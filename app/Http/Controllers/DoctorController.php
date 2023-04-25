<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = QueryBuilder::for (Doctor::class)
            ->defaultSort('id')
            ->allowedSorts(['name','phone','specialty','date_of_birth','tilte'])
            ->allowedFilters(['name','phone','anther_phone','specialty','date_of_birth','tilte'])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();

        return Inertia::render('Doctors/Index', [
            'doctors' => $doctors
        ])->table(function (InertiaTable $table) {
            $table->column(
                key:'id',
                label:__('ID'),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:'name',
                label:__('Name'),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:'phone',
                label:__('Phone Number'),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:'anther_phone',
                label:__('Anther Phone'),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:'specialty',
                label:__('Speciatly'),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:'title',
                label:__('Title'),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:'date_of_birth',
                label:__('Age'),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:'actions',
                label:__("Actions")
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
            'name' => ['string','max:255','required'],
            'phone' => ['string','max:255','required'],
            'another_phone' => ['nullable','string','max:255'],
            'date_of_birth' => ['date','required'],
            'specialty' => ['string','max:255','required'],
            'title' => ['string','max:255','required'],
        ]);
        $doc = new Doctor();
        $doc->name = $request->name;
        $doc->phone = $request->phone;
        $doc->another_phone = $request->another_phone;
        $doc->date_of_birth = $request->date_of_birth;
        $doc->specialty = $request->specialty;
        $doc->title = $request->title;
        $doc->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $date = $request->validate([
            'name' => ['string','max:255','required'],
            'phone' => ['string','max:255','required'],
            'another_phone' => ['nullable','string','max:255'],
            'date_of_birth' => ['date','required'],
            'specialty' => ['string','max:255','required'],
            'title' => ['string','max:255','required'],
        ]);
        $doctor->update($date);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
    }

    public function all(){
        return Doctor::all();
    }
}
