<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Patient;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{

    public function index()
    {
        $appointments = QueryBuilder::for(Appointment::class)
            ->with('doctor')
            ->with('room')
            ->defaultSort('id')
            ->allowedSorts(['id', 'date'])
            ->allowedFilters(['date'])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();

        return Inertia::render('Appointments/Index', [
            'appointments' => $appointments
        ])->table(function (InertiaTable $table) {
            $table->column(
                key: "id",
                label: "ID",
                canBeHidden: false,
                hidden: false,
                sortable: true
            )->column(
                key: "date",
                label: "Date",
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "from",
                label: "From",
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "to",
                label: "To",
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "room",
                label: "Room",
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "doctor",
                label: "Doctor",
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "actions",
                label: "Actions"
            );
        });
    }


    public function create()
    {
        //
    }
    // عشان نعرف كل مريض هيقعد قد ايه
    public function timeInterval($startdate, $endDate, $numOfCases)
    {
        $from = new Carbon($startdate);
        $to = new Carbon($endDate);
        $diff = $from->floatDiffInMinutes($to, true);
        $interval = floor($diff / $numOfCases);
        settype($interval, 'integer');
        return $interval;
    }

    public function store(Request $request)
    {
        // dd($request);
        $today = Carbon::parse('today');
        $timesArr = array();


        $data = $request->validate([
            'doctor_id' => ['numeric', 'required', 'exists:App\Models\Doctor,id'],
            'clinic_id' => ['numeric', 'required', 'exists:App\Models\Clinic,id'],
            'records' => ['required', 'array', 'min:1'],
            'records.*.date' => ['date', 'required', 'after_or_equal:' . $today],
            'records.*.room_id' => ['numeric', 'required', 'exists:App\Models\Room,id'],
            'records.*.num_of_cases' => ['numeric', 'min:1', 'required'],
            'records.*.from' => ['required'],
            'records.*.to' => ['required'],
            'records.*.repeat' => ['nullable']
        ]);


        //transaction begin
        // DB::beginTransaction();
        foreach ($data['records'] as $item) {
            if ($item['repeat']) {
                for ($i = 0; $i < 2; $i++) {
                    if ($i == 0) {
                        $from = $item['date'] . " " . $item['from'];
                        $to = $item['date'] . " " . $item['to'];
                        $interval = $this->timeInterval($from, $to, $item['num_of_cases']);
                        $timesObjs = CarbonInterval::minutes($interval)->toPeriod($from, $to)->toArray();
                        $timesArr = array_map(fn ($time) => $time->format('H:i'), $timesObjs);
                        $j = 0;
                        while ($j < count($timesArr) - 1) {
                            $apt = new Appointment();
                            $apt->doctor_id = $data['doctor_id'];
                            $apt->clinic_id = $data['clinic_id'];
                            $apt->room_id = $item['room_id'];
                            $apt->date = $item['date'];
                            $apt->from = $item['date'] . " " . $timesArr[$j++];
                            $apt->to = $item['date'] . " " . $timesArr[$j];
                            $apt->save();
                        }
                    } elseif ($i == 1) {
                        $nextdate = Carbon::parse($item['date'])->addWeeks(1)->toDateString();
                        $from = $nextdate . " " . $item['from'];
                        $to = $nextdate . " " . $item['to'];
                        $interval = $this->timeInterval($from, $to, $item['num_of_cases']);
                        $timesObjs = CarbonInterval::minutes($interval)->toPeriod($from, $to)->toArray();
                        $timesArr = array_map(fn ($time) => $time->format('H:i'), $timesObjs);
                        $j = 0;
                        while ($j < count($timesArr) - 1) {
                            $apt = new Appointment();
                            $apt->doctor_id = $data['doctor_id'];
                            $apt->clinic_id = $data['clinic_id'];
                            $apt->room_id = $item['room_id'];
                            $apt->date = $nextdate;
                            $apt->from = $nextdate . " " . $timesArr[$j++];
                            $apt->to = $nextdate . " " . $timesArr[$j];
                            $apt->save();
                        }
                    }
                }
            } else {
                //validate that the range of dates in this room is free
                // $conflicFrom = DB::table('appointments')
                //     ->where('date', $item['date'])
                //     ->where('room_id', $item['room_id'])
                //     ->get();
                // $r = $conflicFrom->groupBy('doctor_id');
                // dd($conflicFrom);

                $from = $item['date'] . " " . $item['from'];
                $to = $item['date'] . " " . $item['to'];
                $interval = $this->timeInterval($from, $to, $item['num_of_cases']);
                $timesObjs = CarbonInterval::minutes($interval)->toPeriod($from, $to)->toArray();
                $timesArr = array_map(fn ($time) => $time->format('H:i'), $timesObjs);
                $j = 0;
                while ($j < count($timesArr) - 1) {
                    $apt = new Appointment();
                    $apt->doctor_id = $data['doctor_id'];
                    $apt->clinic_id = $data['clinic_id'];
                    $apt->room_id = $item['room_id'];
                    $apt->date = $item['date'];
                    $apt->from = $item['date'] . " " . $timesArr[$j++];
                    $apt->to = $item['date'] . " " . $timesArr[$j];
                    $apt->save();
                }
            }
        }
        // DB::commit();
    }


    public function show(Appointment $appointment)
    {
        return array($appointment, $appointment->patient);
    }


    public function edit(Appointment $appointment)
    {
        //
    }


    public function update(Request $request, Appointment $appointment)
    {
        //
    }


    public function destroy(Appointment $appointment)
    {
        // dd($appointment);
        $appointment->patient_id = null;
        $appointment->save();
    }

    public function searchData(Request $request)
    {
        if ($request->doctor_id == -1) {
            $result = Appointment::where('date', '=', $request->date)
                ->with('doctor')
                ->with('patient')
                ->get();

            $appointments = $result->groupBy('doctor_id');
        } else {
            $result = Appointment::where('doctor_id', '=', $request->doctor_id)
                ->where('date', '=', $request->date)
                ->with('doctor')
                ->with('patient')
                ->get();

            $appointments = $result->groupBy('doctor_id');
        }
        return $appointments;
    }

    public function reserve(Request $request)
    {
        // dd($request);
        $request->validate([
            'appointment_type' => ['string', 'required', Rule::in(['Normal', 'Emergency', 'Consultation'])],
            'patient' => ['required']
        ]);

        $appointment = Appointment::find($request->query('appointment_id'));
        $appointment->patient_id = $request->patient["id"];
        $appointment->type = $request->appointment_type;
        $appointment->save();
        // dd($request->form);
    }

    public function reserveNewPatient(Request $request)
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
            'appointment_type' => ['string', 'required', Rule::in(['Normal', 'Emergency', 'Consultation'])]
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

        $appointment = Appointment::find($request->input('appointment_id'));
        $appointment->type = $request->appointment_type;
        $patient->appointments()->save($appointment);
        // dd($request);
    }

    public function cancelUnreserved(Request $request)
    {
        $appointments = Appointment::where('doctor_id', '=', $request->doctor_id)
            ->with('doctor')
            ->where('date', '=', $request->date)
            ->where('patient_id', '=', null)
            ->get();
        // dd($appointments);
        foreach ($appointments as $appointment) {
            $appointment->delete();
        }
        return "unreserverd appointments of doctor " . $appointments[0]['doctor']['name'] . " in date " . $request->date . " have been cancelled";
    }

    public function cancelAll(Request $request)
    {
        $appointments = Appointment::where('doctor_id', '=', $request->doctor_id)
            ->with('doctor')
            ->with('patient')
            ->where('date', '=', $request->date)
            ->get();
        foreach ($appointments as $appointment) {
            if ($appointment->patient_id != null) {
                $appointment->cancelled = 1;
                $appointment->update();
            } else {
                $appointment->delete();
            }
        }
        // dd($appointments);
        return $appointments;
    }

    public function pay(Request $request)
    {
        // dd($request);
        $request->validate([
            'amount' =>['required'],
            'current_team_id' =>['required'],
        ]);

        $appointment = Appointment::find($request->appointment_id);

        $appointment->amount = $request->amount;
        $appointment->status = "paid";
        if ($request->notes) {
            $appointment->notes = $request->notes;
        }
        $appointment->save();

        $payments = new Payment;
        $payments->appointment_id = $appointment->id;
        $payments->patient_id = $appointment->patient_id;
        $payments->doctor_id = $appointment->doctor_id;
        $payments->paid_amount = $request->amount;
        $payments->date = $request->date;
        $payments->receiver_team_id = $request->current_team_id; //1->reseptionist 2->doctor
        if($request->reseptionist_id !== ""){
            $payments->receiver_id = $request->reseptionist_id;
        }else{
            $payments->receiver_id = $request->doctor_id;
        }
        $payments->save();
    }

    public function showHistory($patient_id)
    {
        $patient_appointments = Appointment::where('patient_id', '=', $patient_id)->get();
        return $patient_appointments;
    }
}
