<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\PrescriptionItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Fee;
use App\Models\Payment;
use App\Models\Spending;
use Illuminate\Support\Facades\Auth;


class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prescriptions = QueryBuilder::for(Prescription::class)
            ->with('doctor')
            ->with('patient')
            ->with('prescriptionItems')
            ->allowedSorts(['id', 'doctor_id', 'patient_id', 'dateTimeIssued'])
            ->allowedFilters(['id', 'doctor.name', 'patient.name', 'dateTimeIssued'])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();

        return Inertia::render(
            'Prescriptions/Index',
            ['prescriptions' => $prescriptions]
        )->table(function (InertiaTable $table) {
            $table->column(
                key: "id",
                label: __("ID"),
                canBeHidden: true,
                hidden: false,
                sortable: true
            )->column(
                key: "doctor.name",
                label: __("Doctor"),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "patient.name",
                label: __("Patient"),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "dateTimeIssued",
                label: __("Date"),
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->current_team_id == 1) {
            return redirect('/');
        } else {
            return Inertia::render('Prescriptions/Add');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);

        $today = Carbon::parse('today')->format('Y-m-d');

        $request->validate([
            'patient_id' => ['required', 'exists:App\Models\Patient,id'],
            'appointment_id' => ['required', 'exists:App\Models\Appointment,id'],
            'dateTimeIssued' => ['required', 'date_equals:' . $today],
            'prescriptionLines' => ['array', 'nullable'],
            'services' => ['array', 'nullable'],
            'diagnosis' => ['array', 'nullable'],
            'analysis' => ['array', 'nullable'],
            'rays' => ['array', 'nullable'],
            'notes' => ['nullable'],
            'selected_clinic.id' => ['required', 'exists:App\Models\Clinic,id']
        ]);

        $prescription = new Prescription();
        $prescription->patient_id = $request->patient_id;
        $prescription->appointment_id = $request->appointment_id;
        $prescription->clinic_id = $request->selected_clinic['id'];
        $prescription->doctor_id = Auth::user()->doc_res_id;
        $prescription->dateTimeIssued = Carbon::parse($request->dateTimeIssued)->addHours(3)->addMinutes(5);

        $prescription->diagnosis = is_array($request->diagnosis) ? json_encode($request->diagnosis) : $request->diagnosis;
        $prescription->analysis = is_array($request->analysis) ? json_encode($request->analysis) : $request->analysis;
        $prescription->rays = is_array($request->rays) ? json_encode($request->rays) : $request->rays;
        $prescription->notes = $request->notes;
        $prescription->save();

        $appointment = Appointment::where('patient_id', $request->patient_id)
            ->where('date', $today)
            ->where('doctor_id', '=', $prescription->doctor_id)
            ->first();
        $appointment->done = 1;
        $appointment->update();

        // $total_service_fees = 0;


        for ($i = 0; $i < count($request->prescriptionLines); $i++) {
            $prescriptionItem = new PrescriptionItems();
            $prescriptionItem->drug_id = $request->prescriptionLines[$i]['id'];
            if (!empty($request->prescriptionLines[$i]['dose'])) {
                $dose = DB::table('doses')->where('name', '=', $request->prescriptionLines[$i]['dose'])->first();
                if (!$dose) {
                    $dose = DB::table('doses')->insert([
                        'name' => $request->prescriptionLines[$i]['dose']
                    ]);
                }
                $prescriptionItem->dose = $request->prescriptionLines[$i]['dose'];
            } else {
                $prescriptionItem->dose = null;
            }
            // if (!empty($request->prescriptionLines[$i]['cost'])) {
            //     $prescriptionItem->service_fees = $request->prescriptionLines[$i]['cost'];
            //     $total_service_fees = $total_service_fees + $request->prescriptionLines[$i]['cost'];
            // } else {
            //     $prescriptionItem->service_fees = null;
            // }

            $prescription->prescriptionItems()->save($prescriptionItem);
        }

        foreach($request->services as $service){
            $prescriptionItem2 = new PrescriptionItems();
            $prescriptionItem2->service_id = $service['id'];
            $prescription->prescriptionItems()->save($prescriptionItem2);
            $additional_fees = new Fee();
            $additional_fees->appointment_id = $request->appointment_id;
            $additional_fees->patient_id = $request->patient_id;
            $additional_fees->service_id = $service['id'];
            $additional_fees->price = $service['default_price'];
            $additional_fees->date = $today;
            $additional_fees->save();
        }

        // $payment = Payment::where('patient_id', '=', $request->patient_id)
        //     ->where('appointment_id', '=', $appointment->id)->first();
        // if (!is_null($payment->total_service_fees)) {
        //     $payment->total_service_fees += $total_service_fees;
        // }else{
        //     $payment->total_service_fees = $total_service_fees;
        // }
        // $payment->update();
    }
    /**
     * Display the specified resource.
     */
    public function show(Prescription $prescription)
    {
        //
    }

    public function getHistory($patient_id)
    {
        $patient_history = Prescription::with('patient')
            ->with('doctor')
            ->where('patient_id', '=', $patient_id)
            ->where('doctor_id', '=', Auth::user()->doc_res_id)
            ->get();
        return $patient_history;
    }

    public function getTodaysPatients($clinic_id)
    {
        $today = Carbon::parse('today')->format('Y-m-d');
        $appointmentsToday = Appointment::where('date', '=', $today)
            ->where('doctor_id', Auth::user()->doc_res_id)->with('patient')
            ->where('clinic_id', $clinic_id)
            ->get();
        return $appointmentsToday;
    }

    public function getItemsFees($appointment_id)
    {


        $fees = Fee::where('appointment_id','=',$appointment_id)->get();
        // dd($fees);
        // $today = Carbon::parse('today')->format('Y-m-d');
        // dd($today);
        // $prescriptionItems = Prescription::where('appointment_id', '=', $appointment_id)
        //     ->with('prescriptionItems')
        //     ->with('prescriptionItems.drugs')
        //     ->with('appointment')
        //     ->with('appointment.payment')
        //     ->get();
        // $payment = Payment::where('appointment_id', '=', $appointment_id)
        //                   ->get();  
        return $fees;
        // dd($prescriptionItems);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prescription $prescription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prescription $prescription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prescription $prescription)
    {
        $PIs = $prescription->prescriptionItems;
        // $pi[0]->delete();
        // if (!is_array($PIs))
        // 	$PIs = [$PIs];
        for ($i = 0; $i < count($PIs); $i++) {
            $PIs[$i]->delete();
        }
        $prescription->delete();
    }

    public function indexDiagnosis_json()
    {
        if (File::exists(public_path() . '/json/Diagnosis.json')) {
            //get data from file
            $diagnosis = file_get_contents(public_path() . '/json/Diagnosis.json');
            return json_decode($diagnosis);
        } else {
            return [];
        }
    }

    public function indexAnalysis_json()
    {
        if (File::exists(public_path() . '/json/Analysis.json')) {
            //get data from file
            $analysis = file_get_contents(public_path() . '/json/Analysis.json');
            return json_decode($analysis);
        } else {
            return [];
        }
    }

    public function indexRays_json()
    {
        if (File::exists(public_path() . '/json/Rays.json')) {
            //get data from file
            $rays = file_get_contents(public_path() . '/json/Rays.json');
            return json_decode($rays);
        } else {
            return [];
        }
    }

    public function index_doses()
    {
        return DB::table('doses')->get();
    }

    public function index_duration()
    {
        return DB::table('durations')->get();
    }
}
