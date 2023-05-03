<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PatientController extends Controller
{

    public function index()
    {
        $patients = QueryBuilder::for (Patient::class)
        ->defaultSort('id')
        ->allowedSorts(['id','name','date_of_birth'])
        ->allowedFilters(['name','phone','type','date_of_birth','insurance_number','insurance_company','gender'])
        ->paginate(Request()->input('perPage',20))
        ->withQueryString();

        return Inertia::render('Patients/Index', [
            'patients' => $patients
        ])->table(function (InertiaTable $table) {
            $table->column(
                key:"id",
                label:__("ID"),
                canBeHidden:false,
                hidden:false,
                sortable:true,
            )->column(
                key:"name",
                label: __("Name"),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"gender",
                label: __("Gender"),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"date_of_birth",
                label: __("Age"),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"type",
                label: __("Type"),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"insurance_number",
                label: __("Insurance Number"),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"insurance_company",
                label: __("Insurance Company"),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"phone",
                label: __("Phone Number"),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"actions",
                label: __("Actions"),
            );
        });
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $today = Carbon::parse('today');

        $request->validate([
            'name' =>['string','max:255','min:2','required'],
            'phone' =>['numeric','min:11','required'],
            'type' =>['required',Rule::in(['I','P'])],
            'gender' =>['required',Rule::in(['M','F'])],
            'date_of_birth' => ['date','required','before_or_equal:'.$today],
            'insurance_number' =>['string','max:255','nullable'],
            'insurance_company' =>['string','max:255','nullable'],
        ]);

        $patient = new Patient();
        $patient->name = $request->name;
        $patient->phone = $request->phone;
        $patient->type = $request->type;
        $patient->gender = $request->gender;
        $patient->date_of_birth = $request->date_of_birth;
        $patient->insurance_number = $request->insurance_number;
        $patient->insurance_company = $request->insurance_company;
        $patient->save();

        return redirect()->back();
    }

    public function show(Patient $patient)
    {
        //
    }

    public function edit(Patient $patient)
    {
        //
    }

    public function update(Request $request, Patient $patient)
    {
        $today = Carbon::parse('today');

        $date = $request->validate([
            'name' =>['string','max:255','min:2','required'],
            'phone' =>['numeric','min:11','required'],
            'type' =>['required',Rule::in(['I','P'])],
            'gender' =>['required',Rule::in(['M','F'])],
            'date_of_birth' => ['date','required','before_or_equal:'.$today],
            'insurance_number' =>['string','max:255','nullable'],
            'insurance_company' =>['string','max:255','nullable'],
        ]);

        $patient->update($date);
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
    }

    public function all(){
        return Patient::all();
    }
}
