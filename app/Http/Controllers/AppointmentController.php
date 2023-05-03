<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

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
        // $today = Carbon::parse('today');
        $timesArr = array();

        for ($i = 0; $i < count($request->records); $i++) {
    
            // $request->records[$i]->validate([
            //     'date' =>['date','required','after_or_equal:'.$today],
            //     'doctor_id' =>['numeric','required'],
            //     'room_id' =>['numeric','required'],
            //     'num_of_cases'=>['numeric','min:1','required'],
            //     'from'=>['required'],
            //     'to'=>['required']
            // ]);

            $from = $request->records[$i]['date'] . " " . $request->records[$i]['from'];
            $to = $request->records[$i]['date'] . " " . $request->records[$i]['to'];
            $interval = $this->timeInterval($from, $to, $request->records[$i]['num_of_cases']);
            $timesObjs = CarbonInterval::minutes($interval)->toPeriod($from, $to)->toArray();
            $timesArr = array_map(fn ($time) => $time->format('H:i'), $timesObjs);

            $j = 0;
            while ($j < count($timesArr) - 1) {
                $apt = new Appointment();
                $apt->doctor_id = $request->doctor_id;
                $apt->room_id = $request->records[$i]['room_id'];
                $apt->date = $request->records[$i]['date'];
                $apt->from = $request->records[$i]['date'] . " " . $timesArr[$j++];
                $apt->to = $request->records[$i]['date'] . " " . $timesArr[$j];
                $apt->save();
            }
        }
    }

    public function show(Appointment $appointment)
    {
        return array($appointment,$appointment->patient) ;
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
        $appointment->delete();
    }

    public function searchData(Request $request)
    {
        if($request->doctor_id == -1){
            $result = Appointment::where('date', '=', $request->date)
            ->with('doctor')
            ->get();

            $appointments = $result->groupBy('doctor_id');

        }else {
            $result = Appointment::where('doctor_id', '=', $request->doctor_id)
            ->where('date', '=', $request->date)
            ->with('doctor')
            ->get();

            $appointments = $result->groupBy('doctor_id');
        }
        return $appointments;
    }

    public function reserve(Request $request){
        $appointment = Appointment::find($request->input('appointment_id'));
        $appointment->patient_id = $request->id;
        $appointment->save();
    }

    public function reserveNewPatient(Request $request){

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

        $appointment = Appointment::find($request->input('appointment_id'));
        $patient->appointments()->save($appointment);
    }
}
