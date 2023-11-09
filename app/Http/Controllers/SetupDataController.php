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
use App\Http\Traits\ExcelWrapper;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SetupDataController extends Controller
{
    use ExcelWrapper;
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
            //     // "numberOfDoctors" => ['required'],
            //     // "numberOfPatients" => ['required', 'min:1'],
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


        //doctors
        $temp = $this->xlsxToArray(public_path() . '/ExcelTemplates/Demo/DoctorDemo.xlsx');
        foreach ($temp as $key => $value) {
            $spc = Specialty::where('name', '=', $temp[$key]['specialty'])->first();
            $doc = new Doctor();
            $doc->name = $temp[$key]['name'];
            $doc->phone = $temp[$key]['phone'];
            $doc->date_of_birth = $this->excelDateToDatetime($temp[$key]['date_of_birth']);
            $doc->specialty_id = $spc->id;
            $doc->title = $temp[$key]['title'];
            $doc->save();
            User::create([
                'name' => $doc->name,
                'email' => $temp[$key]['email'],
                'password' => Hash::make("123456789"),
                'current_team_id' => 2,
                'doc_res_id' => $doc->id
            ]);
        }

        //patients
        $temp = $this->xlsxToArray(public_path() . '/ExcelTemplates/Demo/PatientDemo.xlsx');
        foreach ($temp as $key => $value) {
            $new_patient = new Patient();
            $new_patient->name = $temp[$key]['name'];
            $new_patient->gender = $temp[$key]['gender (M|F)'];
            $new_patient->phone = $temp[$key]['phone'];
            $new_patient->type = $temp[$key]['type (P|I)'];
            $new_patient->date_of_birth = $this->excelDateToDatetime($temp[$key]['date_of_birth']);
            $new_patient->insurance_number = $temp[$key]['insurance_number'] ? $temp[$key]['insurance_number'] : null;
            $new_patient->insurance_company = $temp[$key]['insurance_company'] ? $temp[$key]['insurance_company'] : null;
            $new_patient->additionalInformation = $temp[$key]['additionalInformation'] ? $temp[$key]['additionalInformation'] : null;
            $new_patient->save();
        }

        //drugs - diagnosis - doses
        $temp = $this->xlsxToArray(public_path() . '/ExcelTemplates/Demo/DrugDemo.xlsx');
        foreach ($temp as $key => $value) {
            $speciality = $temp[$key]['spaeciality'];
            $diagnosis = [];

            for ($i = 1; $i <= 10; $i++) {
                if ($temp[$key]['diagnose ' . $i]) {
                    array_push($diagnosis, $temp[$key]['diagnose ' . $i]);
                } else {
                    continue;
                }
            }

            $drug = new Drug();
            $drug->name = $temp[$key]['name'];
            $drug->description = $temp[$key]['description'];
            $drug->save();

            DB::table('doses')->insert([
                'name' => $temp[$key]['default dose']
            ]);

            foreach ($diagnosis as $val) {
                $diagnose = Diagnosis::where('name', '=', $val)->first();
                if (!$diagnose) {
                    $spc = Specialty::where('name', '=', $speciality)->first();
                    if (!$spc) {
                        $sp = new Specialty();
                        $sp->name = $speciality;
                        $sp->save();
                        $dgsn = new Diagnosis();
                        $dgsn->name = $val;
                        $dgsn->description = null;
                        $sp->diagnosis()->save($dgsn);
                        $drug->diagnosis()->attach($dgsn->id);
                    } else {
                        $dgsn = new Diagnosis();
                        $dgsn->name = $val;
                        $dgsn->description = null;
                        $dgsn->specialty_id = $spc->id;
                        $dgsn->save();
                        $drug->diagnosis()->attach($dgsn->id);
                    }
                } else {
                    continue;
                }
            }
        }

        
        // //add rays
        for ($i = 1; $i <= 30; $i++) {
            $ray = new XRay();
            $ray->name = "xray-" . $i;
            $ray->specialty_id = rand(1, $num_of_specialties);
            $ray->save();
        }

        // //add analysis
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
        $patients = Patient::all();

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
                $apt->patient_id = $j<= 25? $patients[$j]->id: null;
                $apt->from = $day . " " . $timesArrayFormated[$j++];
                $apt->to = $day . " " . $timesArrayFormated[$j];
                $apt->type = $appointment_types[rand(0, count($appointment_types) - 1)];
                $apt->status = "hold";
                $apt->save();
            }
        }

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
