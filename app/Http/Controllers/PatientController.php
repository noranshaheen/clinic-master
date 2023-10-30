<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Http\Traits\ExcelWrapper;

class PatientController extends Controller
{
    use ExcelWrapper;

    public function index()
    {
        $patients = QueryBuilder::for(Patient::class)
            ->with('prescriptions')
            ->defaultSort('id')
            ->allowedSorts(['id', 'name', 'phone', 'type', 'date_of_birth', 'insurance_number', 'insurance_company', 'gender'])
            ->allowedFilters(['id', 'name', 'phone', 'type', 'date_of_birth', 'insurance_number', 'insurance_company', 'gender'])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();

        return Inertia::render('Patients/Index', [
            'patients' => $patients
        ])->table(function (InertiaTable $table) {
            $table->column(
                key: "id",
                label: __("ID"),
                canBeHidden: false,
                hidden: false,
                sortable: true,
            )->column(
                key: "name",
                label: __("Name"),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "gender",
                label: __("Gender"),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "date_of_birth",
                label: __("Age"),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "type",
                label: __("Type"),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "insurance_number",
                label: __("Insurance Number"),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "insurance_company",
                label: __("Insurance Company"),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "phone",
                label: __("Phone Number"),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "actions",
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
            'name' => ['string', 'max:255', 'min:2', 'required', 'regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'phone' => ['numeric', 'min:11', 'required'],
            'type' => ['required', Rule::in(['I', 'P'])],
            'gender' => ['required', Rule::in(['M', 'F'])],
            'date_of_birth' => ['date', 'before_or_equal:' . $today],
            'insurance_number' => ['string', 'max:255', 'nullable'],
            'insurance_company' => ['string', 'max:255', 'nullable'],
            'additionalInformation' => ['string', 'max:4000', 'nullable'],
        ]);

        $patient = new Patient();
        $patient->name = $request->name;
        $patient->phone = $request->phone;
        $patient->type = $request->type;
        $patient->gender = $request->gender;
        $patient->date_of_birth = $request->date_of_birth;
        $patient->insurance_number = $request->insurance_number;
        $patient->insurance_company = $request->insurance_company;
        $patient->additionalInformation = $request->additionalInformation;
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

        $date =  $request->validate([
            'name' => ['string', 'max:255', 'min:2', 'required', 'regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'phone' => ['numeric', 'min:11', 'required'],
            'type' => ['required', Rule::in(['I', 'P'])],
            'gender' => ['required', Rule::in(['M', 'F'])],
            'date_of_birth' => ['date', 'required', 'before_or_equal:' . $today],
            'insurance_number' => ['string', 'max:255', 'nullable'],
            'insurance_company' => ['string', 'max:255', 'nullable'],
            'additionalInformation' => ['string', 'max:4000', 'nullable'],
        ]);
        $patient->additionalInformation = $request->additionalInformation;
        $patient->save();
        $patient->update($date);
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
    }

    public function all()
    {
        return Patient::all();
    }

    public function getHistory($patient_id)
    {

        $patient_history = Prescription::with('doctor')
            ->with('prescriptionItems')
            ->with('prescriptionItems.drug')
            ->with('appointment')
            ->with('appointment.payments')
            ->with('patient')
            ->where('patient_id', '=', $patient_id)->get();
        $payments = Payment::where('patient_id', '=', $patient_id)
            ->with('appointment')
            ->with('appointment.fees')
            ->with('doctor')
            ->get()
            ->groupBy('date');
    
        return Inertia::render('Patients/History', [
            'prescriptions' => $patient_history,
            'payments' => $payments
        ]);
    }

    public function UploadPatients(Request $request)
    {
        $temp = [];
        $extension = $request->file->extension();
        if ($extension == 'xlsx' || $extension == 'xls')
            $temp = $this->xlsxToArray($request->file, $extension);
        elseif ($extension == 'csv')
            $temp = $this->csvToArray($request->file);
        else
            return json_encode(["Error" => true, "Message" => __("Unsupported File Type!")]);

        foreach ($temp as $key => $value) {
            $patient = Patient::where("name", "=", $temp[$key]["name"])->first();
            if (!$patient) {
                $new_patient = new Patient();
                $new_patient->name = $temp[$key]['name'];
                $new_patient->gender = $temp[$key]['gender (M|F)'];
                $new_patient->phone = "0" . $temp[$key]['phone'];
                $new_patient->type = $temp[$key]['type (P|I)'];
                $new_patient->date_of_birth = $this->excelDateToDatetime($temp[$key]['date_of_birth']);
                $new_patient->insurance_number = $temp[$key]['insurance_number'] ? $temp[$key]['insurance_number'] : null;
                $new_patient->insurance_company = $temp[$key]['insurance_company'] ? $temp[$key]['insurance_company'] : null;
                $new_patient->additionalInformation = $temp[$key]['additionalInformation'] ? $temp[$key]['additionalInformation'] : null;
                $new_patient->save();
            } else {
                $data = [
                    "name" => $temp[$key]['name'],
                    "gender" => $temp[$key]['gender (M|F)'],
                    "phone" => $temp[$key]['phone'],
                    "type" => $temp[$key]['type (P|I)'],
                    "date_of_birth" => $this->excelDateToDatetime($temp[$key]['date_of_birth']),
                    "insurance_number" => $temp[$key]['insurance_number'] ? $temp[$key]['insurance_number'] : null,
                    "insurance_company" => $temp[$key]['insurance_company'] ? $temp[$key]['insurance_company'] : null,
                    "additionalInformation" => $temp[$key]['additionalInformation'] ? $temp[$key]['additionalInformation'] : null,
                ];
                $patient->update($data);
            }
        }
    }
}
