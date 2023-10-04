<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use App\Models\Clinic;
use App\Models\Diagnosis;
use App\Models\Doctor;
use App\Models\Drug;
use App\Models\Patient;
use App\Models\Room;
use App\Models\Specialty;
use App\Models\User;
use App\Models\Appointment;
use App\Models\XRay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SetupDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function demo_step1_store(Request $request)
    {
        // dd($request);

        // validation
        $request->validate([
            "name" => ['required'],
            "phone" => ['required'],
            "address" => ['required'],
            "numberOfRooms" => ['required'],
            "numberOfDoctors" => ['required'],
            "numberOfPatients" => ['required', 'min:1'],
        ]);

        $num_of_specialties = Specialty::all()->count();

        //add clinic branch
        $clinic = new Clinic();
        $clinic->name = $request->name;
        $clinic->phone = $request->phone;
        $clinic->address = $request->address;
        $clinic->save();

        //add rooms
        for ($i = 1; $i <= $request->numberOfRooms; $i++) {
            $room = new Room();
            $room->name = "room-" . $i;
            $room->clinic_id = 1;
            $room->save();
        }

        //add doctors
        $titles = ["طبيب الامتياز", "طبيب مقيم", "أخصائي", "أخصائي أول", "إستشاري", "استشاري أول", "دكتوراه / بروفيسور"];
        for ($i = 1; $i <= $request->numberOfDoctors; $i++) {
            $doctor = new Doctor();
            $doctor->name = fake()->name();
            $doctor->phone = fake()->phoneNumber();
            $doctor->specialty_id = rand(1, $num_of_specialties);
            $doctor->title = $titles[rand(0, count($titles) - 1)];
            $doctor->date_of_birth = "1990-01-01";
            $doctor->save();

            User::create([
                'name' => $doctor->name,
                'email' => "doctor" . $i . "@master.com",
                'password' => Hash::make("123456789"),
                'current_team_id' => 2,
                'doc_res_id' => $doctor->id
            ]);
        }


        //add patients
        for ($i = 1; $i <= $request->numberOfPatients; $i++) {
            $patient = new Patient();
            $patient->name = fake()->name();
            $patient->gender = "M";
            $patient->phone = fake()->phoneNumber();
            $patient->type = "P";
            $patient->date_of_birth = "2000-01-01";
            $patient->save();
        }

        //add diagnoses
        for ($i = 1; $i <= 30; $i++) {
            $diagnose = new Diagnosis();
            $diagnose->name = "تشخيص" . $i;
            $diagnose->specialty_id = rand(1, $num_of_specialties);
            $diagnose->save();
        }

        //add drugs
        $num_of_diagnoses = Diagnosis::all()->count();
        for ($i = 1; $i <= 50; $i++) {
            $drug = new Drug();
            $drug->name = "drug" . $i;
            $drug->save();
            $drug->diagnosis()->attach(rand(1, $num_of_diagnoses));
        }

        //add doses
        $doses = [
            '10 ملغ/ كغ 3 مرات في اليوم',
            '500 ملغ كل 8 ساعات',
            '250 ملغ كل 12 ساعات',
            'كبسولة مرتين قي اليوم',
            'كبسولتين كل 8 ساعات'
        ];
        for ($i = 1; $i <= 10; $i++) {
            DB::table('doses')->insert([
                'name' => $doses[rand(0, count($doses) - 1)]
            ]);
        }

        //add rays
        for ($i = 1; $i <= 30; $i++) {
            $ray = new XRay();
            $ray->name = "xray-" . $i;
            $ray->specialty_id = rand(1, $num_of_specialties);
            $ray->save();
        }

        //add analysis
        for ($i = 1; $i <= 30; $i++) {
            $analysis = new Analysis();
            $analysis->name = "analysis-" . $i;
            $analysis->specialty_id = rand(1, $num_of_specialties);
            $analysis->save();
        }

        //add items
        

        //add inventories

        return "date stored succefully";
    }


    public function timeInterval($startdate, $endDate, $numOfCases)
    {
        $from = new Carbon($startdate);
        $to = new Carbon($endDate);
        $diff = $from->floatDiffInMinutes($to, true);
        $interval = floor($diff / $numOfCases);
        settype($interval, 'integer');
        return $interval;
    }


    public function demo_step2_store(Request $request)
    {
        //make appointments

        // dd($request);

        //validation
        $request->validate([
            "name"      => ['required'],
            "date"      => ['required'],
            "room"      => ['required'],
            "doctor"    => ['required'],
            "from"      => ['required'],
            "to"        => ['required'],
        ]);


        $today = Carbon::parse('today')->format('Y-m-d');
        $tomorrow = Carbon::parse('tomorrow')->format('Y-m-d');
        $yesterday = Carbon::parse('yesterday')->format('Y-m-d');
        $timesArray = array();
        $patients = Patient::all()->count();

        $days = [$yesterday, $today, $tomorrow];
        $appointment_types = ['كشف مستعجل', 'استشاره', 'كشف عادي'];

        foreach ($days as $day) {
            $from = $day . " " . $request['from'];
            $to = $day . " " . $request['to'];
            $interval = $this->timeInterval($from, $to, $request['numberOfCases']);
            $timesArray = CarbonInterval::minutes($interval)->toPeriod($from, $to)->toArray();
            $timesArrayFormated = array_map(fn ($time) => $time->format('H:i'), $timesArray);
            $j = 0;
            while ($j < count($timesArrayFormated) - 1) {
                $apt = new Appointment();
                $apt->doctor_id = $request['doctor'];
                $apt->clinic_id = 1;
                $apt->room_id = $request['room'];
                $apt->date = $day;
                $apt->from = $day . " " . $timesArrayFormated[$j++];
                $apt->to = $day . " " . $timesArrayFormated[$j];
                $apt->patient_id = rand(1, $patients);
                $apt->type = $appointment_types[rand(0, count($appointment_types) - 1)];
                $apt->status = "hold";
                // dd($apt);
                $apt->save();
            }
        }
        // dd(Appointment::get());
        return "appointments stored succefully";
    }


    public function actual_step1_store(Request $request)
    {
        // dd($request);

        //validation
        $request->validate([
            "clinic_name" => ['required', 'max:255'],
            "clinic_phone" => ['required', 'max:255'],
            "clinic_phone" => ['required', 'max:255'],
            "room1_name" => ['required', 'max:255'],
            "room2_name" => ['nullable', 'max:255'],
        ]);

        //add clinic
        $clinic = new Clinic();
        $clinic->name = $request->clinic_name;
        $clinic->phone = $request->clinic_phone;
        $clinic->address = $request->clinic_address;
        $clinic->save();

        //add rooms
        for ($i = 1; $i <= 2; $i++) {
            if ($i == 2) {
                if ($request->room2_name !== "") {
                    $room = new Room();
                    $room->name = $request->room2_name;
                    $room->clinic_id = $clinic->id;
                    $room->save();

                    return "Data stored successfully";
                }
            } else {
                $room = new Room();
                $room->name = $request->room1_name;
                $room->clinic_id = $clinic->id;
                $room->save();
            }
        }

        return "Data stored successfully";
    }


    public function actual_step2_store(Request $request)
    {
        // dd($request);

        // validation
        $request->validate([
            'email'     => ['required', 'string', 'email', 'max:255'],
            'password'    => ['required', 'min:8'],
        ]);

        $doc = Doctor::latest('id')->first(); //same as DB::table('doctors')->orderBy('id', 'desc')->first(); 
        $user = new User();
        $user->name = $doc->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->doc_res_id = $doc->id;
        $user->current_team_id = 2;
        $user->save();

        return "doctor stored succefully";
    }


    public function actual_step3_store(Request $request)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
