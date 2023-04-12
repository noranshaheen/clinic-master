<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Validation\Rule;

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
                label:"ID",
                canBeHidden:false,
                hidden:false,
                sortable:true,
            )->column(
                key:"name",
                label: "Name",
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"gender",
                label: "Gender",
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"date_of_birth",
                label: "Age",
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"type",
                label: "Type",
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"insurance_number",
                label: "Insurance Number",
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"insurance_company",
                label: "Insurance Company",
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"phone",
                label: "Phone Number",
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"actions",
                label: "Actions",
            );
        });
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' =>['string','max:255','required'],
            'phone' =>['string','max:255','required'],
            'type' =>['required',Rule::in(['I','P'])],
            'gender' =>['required',Rule::in(['M','F'])],
            'date_of_birth' =>['date','required'],
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
        $date = $request->validate([
            'name' =>['string','max:255','required'],
            'phone' =>['string','max:255','required'],
            'type' =>['required',Rule::in(['I','P'])],
            'gender' =>['required',Rule::in(['M','F'])],
            'date_of_birth' =>['date','max:100','required'],
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
