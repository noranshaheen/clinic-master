<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;
use Carbon\Carbon;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = QueryBuilder::for (Doctor::class)
            ->with('specialties')
            ->defaultSort('id')
            ->allowedSorts(['id','name','phone','date_of_birth','title','specialty_id'])
            ->allowedFilters(['id','name','phone','date_of_birth','title','specialty_id','another_phone'])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();

            // dd($doctors);

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
                key:'specialty_id',
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
        $today = Carbon::parse('1-1-2023')->subYears(25);;

        $request->validate([
            'name' => ['string','max:255','min:2','required','regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'phone' => ['numeric','min:11','required','unique:doctors,phone'],
            'another_phone' => ['nullable','numeric','min:11','unique:doctors,another_phone'],
            'date_of_birth' => ['date','required','before_or_equal:'.$today],
            'specialty_id' => ['string','max:255','required'],
            'title' => ['string','max:255','required'],
        ]);
        $doc = new Doctor();
        $doc->name = $request->name;
        $doc->phone = $request->phone;
        $doc->another_phone = $request->another_phone;
        $doc->date_of_birth = $request->date_of_birth;
        $doc->specialty_id = $request->specialty_id;
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
        // dd($request);
        $today = Carbon::parse('today');

        $date = $request->validate([
            'name' => ['string','max:255','min:2','required','regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'phone' => ['numeric','min:11','required','unique:doctors,phone'],
            'another_phone' => ['nullable','numeric','min:11','unique:doctors,another_phone'],
            'date_of_birth' => ['date','required','before_or_equal:'.$today],
            'specialty_id' => ['required'],
            'title' => ['string','max:255','required'],
        ]);
        $doctor->update($date);
        return "Ok";
        // return redirect()->back();
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
