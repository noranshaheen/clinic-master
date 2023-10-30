<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;


class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = QueryBuilder::for(Doctor::class)
            ->with('specialties')
            ->defaultSort('id')
            ->allowedSorts(['id', 'name', 'phone', 'date_of_birth', 'title'])
            ->allowedFilters(['id', 'name', 'phone', 'date_of_birth', 'title', 'specialties.name', 'another_phone'])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();

        // dd($doctors);

        return Inertia::render('Doctors/Index', [
            'doctors' => $doctors
        ])->table(function (InertiaTable $table) {
            $table->column(
                key: 'id',
                label: __('ID'),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: 'name',
                label: __('Name'),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: 'phone',
                label: __('Phone Number'),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: 'anther_phone',
                label: __('Anther Phone'),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: 'specialties.name',
                label: __('Speciatly'),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: 'title',
                label: __('Title'),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: 'date_of_birth',
                label: __('Age'),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: 'actions',
                label: __("Actions")
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
        $today = Carbon::parse('this year')->subYears(25);

        // dd($today);

        $request->validate([
            'name' => ['string', 'max:255', 'min:2', 'required', 'regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'phone' => ['numeric', 'min:11', 'required'],
            'another_phone' => ['nullable', 'numeric', 'min:11'],
            'date_of_birth' => ['date', 'required', 'before_or_equal:' . $today],
            'specialty_id' => ['string', 'max:255', 'required', 'exists:App\Models\Specialty,id'],
            'title' => ['string', 'max:255', 'required'],
        ]);
        $doc = new Doctor();
        $doc->name = $request->name;
        $doc->phone = $request->phone;
        $doc->another_phone = $request->another_phone;
        $doc->date_of_birth = $request->date_of_birth;
        $doc->specialty_id = $request->specialty_id;
        $doc->title = $request->title;
        $doc->save();

        return $doc;
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return $doctor;
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
        $today = Carbon::parse('this year')->subYears(25);

        $date = $request->validate([
            'name' => ['string', 'max:255', 'min:2', 'required', 'regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'phone' => ['numeric', 'min:11', 'required'],
            'another_phone' => ['nullable', 'numeric', 'min:11', 'unique:doctors,another_phone'],
            'date_of_birth' => ['date', 'required', 'before_or_equal:' . $today],
            'specialty_id' => ['required', 'exists:App\Models\Specialty,id'],
            'title' => ['string', 'max:255', 'required'],
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
        $prescription = Prescription::where('doctor_id', '=', $doctor->id)->first();

        if ($prescription) {
            throw ValidationException::withMessages([
                'error' => "can't delete this doctor"
            ]);
        } else {
            $doctor->delete();
        }
    }

    public function all()
    {
        return Doctor::all();
    }
}
