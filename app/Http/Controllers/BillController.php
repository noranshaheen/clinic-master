<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDetails;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Prescription;


class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Bills/Add');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $item = new Bill();
        $item->doctor_id = $request->doctor['id'];
        $item->clinic_id = $request->clinic['id'];
        $item->date = $request->date;
        $item->totalAmount = $request->billTotalAmount;
        $item->save();

        foreach ($request->billLines as $line) {
            $item2 = new BillDetails();
            $item2->item_id = $line['item']['id'];
            $item2->purches_price = $line['unitPrice'];
            $item2->quantity = $line['quantity'];
            $item2->total = $line['total'];
            $item2->date = $request->date;
            // $item2->save();
            $item->billDetails()->save($item2);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill $bill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        //
    }

    public function search()
    {
        return Inertia::render(
            'Bills/Search'
        );
    }

    public function searchIncomeData(Request $request)
    {
        if ($request->clinic['id'] == -1) {
            $doctor_prescriptions = Prescription::with('doctor')
                ->with('prescriptionItems')
                ->with('clinic')
                ->with('appointment')
                ->with('appointment.payment')
                ->where('doctor_id', '=', $request->doctor['id'])
                ->whereBetween('dateTimeIssued', [$request->startDate, $request->endDate])
                ->get();
            return $doctor_prescriptions;
        } elseif ($request->doctor['id'] == -1) {
            $doctor_prescriptions = Prescription::with('doctor')
                ->with('prescriptionItems')
                ->with('clinic')
                ->with('appointment')
                ->with('appointment.payment')
                ->where('clinic_id', '=', $request->clinic['id'])
                ->whereBetween('dateTimeIssued', [$request->startDate, $request->endDate])
                ->get();
            return $doctor_prescriptions;
        } else {
            $doctor_prescriptions = Prescription::with('doctor')
                ->with('prescriptionItems')
                ->with('clinic')
                ->with('appointment')
                ->with('appointment.payment')
                ->where('doctor_id', '=', $request->doctor['id'])
                ->where('clinic_id', '=', $request->clinic['id'])
                ->whereBetween('dateTimeIssued', [$request->startDate, $request->endDate])
                ->get();
            return $doctor_prescriptions;
        }
        // $doctor_incomes = array_filter((array)$doctor_prescriptions,function($var){
        //     global $request;
        //     $var['appointment']['clinic_id'] == $request->clinic['id'];
        // });
    }

    public function searchExpensesData(Request $request)
    {
        // dd($request);
        if ($request->doctor['id'] == -1) {
            $bills = Bill::with('billDetails')
                ->with('doctor')
                ->with('clinic')
                ->where('clinic_id', '=', $request->clinic['id'])
                ->whereBetween('date', [$request->startDate, $request->endDate])
                ->get();
        } elseif ($request->clinic['id'] == -1) {
            $bills = Bill::with('billDetails')
                ->with('doctor')
                ->with('clinic')
                ->where('doctor_id', '=', $request->doctor['id'])
                ->whereBetween('date', [$request->startDate, $request->endDate])
                ->get();
        } else {
            $bills = Bill::with('billDetails')
                ->with('doctor')
                ->with('clinic')
                ->where('doctor_id', '=', $request->doctor['id'])
                ->where('clinic_id', '=', $request->clinic['id'])
                ->whereBetween('date', [$request->startDate, $request->endDate])
                ->get();
        }
        return $bills;
    }
}
