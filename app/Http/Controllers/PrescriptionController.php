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
            ->allowedSorts(['id', 'dateTimeIssued'])
            ->allowedFilters(['dateTimeIssued'])
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
                key: "doctor",
                label: __("Doctor"),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "patient",
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
        $request->validate([
            'patient_id' => ['required'],
            'appointment_id' => ['required'],
            'dateTimeIssued' => ['required'],
        ]);
        $today = Carbon::parse('today')->format('Y-m-d');
        $appointment = Appointment::where('patient_id', $request->patient_id)->where('date', $today)->first();
        $appointment->done = 1;
        $appointment->update();

        $prescription = new Prescription();
        $prescription->patient_id = $request->patient_id;
        $prescription->appointment_id = $request->appointment_id;
        $prescription->clinic_id = $request->selected_clinic['id'];
        $prescription->doctor_id = Auth::user()->doc_res_id;
        $prescription->dateTimeIssued = $request->dateTimeIssued;

        $prescription->diagnosis = is_array($request->diagnosis) ?
            json_encode($request['diagnosis']) : $request['diagnosis'];

        $prescription->analysis = is_array($request->analysis) ?
            json_encode($request['analysis']) : $request['analysis'];

        $prescription->rays = is_array($request->rays) ?
            json_encode($request['rays']) : $request['rays'];

        $prescription->notes = $request->notes;

        $prescription->save();

        for ($i = 0; $i < count($request->prescriptionLines); $i++) {
            $prescriptionItem = new PrescriptionItems();
            $prescriptionItem->drug_id = $request->prescriptionLines[$i]['id'];
            if (array_key_exists("dose", $request->prescriptionLines[$i])) {
                $prescriptionItem->dose = $request->prescriptionLines[$i]['dose'];
            } else {
                $prescriptionItem->dose = null;
            }
            if (array_key_exists("cost", $request->prescriptionLines[$i])) {
                $prescriptionItem->service_fees = $request->prescriptionLines[$i]['cost'];
            } else {
                $prescriptionItem->service_fees = null;
            }

            $prescription->prescriptionItems()->save($prescriptionItem);
        }

        foreach ($request->checkedItems as $item) {
            $spendings = new Spending();
            $spendings->doctor_id = Auth::user()->doc_res_id;
            $spendings->clinic_id = $request->selected_clinic['id'];
            $spendings->item_id   = $item['id'];
            $spendings->quantity  = $item['quantity'];
            $spendings->cost      = $item['quantity'] * $item['selling_price'];
            $spendings->patient_id = $request->patient_id;
            $spendings->save();
        }
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
        $patient_history = Prescription::with('patient')->with('doctor')->where('patient_id', '=', $patient_id)->get();
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

        // dd($appointment_id);
        // $today = Carbon::parse('today')->format('Y-m-d');
        // dd($today);
        $prescriptionItems = Prescription::where('appointment_id', '=', $appointment_id)
            ->with('prescriptionItems')
            ->with('prescriptionItems.drugs')
            ->get();
        return $prescriptionItems;
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
