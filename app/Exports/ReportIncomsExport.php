<?php

  namespace App\Exports;

use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

  use Maatwebsite\Excel\Concerns\FromCollection;

  use Maatwebsite\Excel\Concerns\WithHeadings;



class ReportIncomsExport implements FromCollection {


    // public $request=null;

    // public function __construct($request)
    // {
    //     $this->request = $request;
    // }


//    public function headings(): array {
//     // according to users table
//     return [

//         "Id",

//         "Name",

//         "Email Address",

//         "Phone No.",

//         "Gender",

//         "User Type",

//         "Registered At"

//        ];

//     }




   public function collection(){

    // $endDate = Carbon::parse($this->request->endDate)->endOfDay();

    // $doctor_prescriptions = Prescription::with('doctor')
    //     ->with('prescriptionItems')
    //     ->with('clinic')
    //     ->with('appointment')
    //     ->with('appointment.payment')
    //     ->whereBetween('dateTimeIssued', [$this->request->startDate, $endDate])
    //     ->get();
    // return $doctor_prescriptions;

    return Prescription::with('appointment')->get();
   }

}