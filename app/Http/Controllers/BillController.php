<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDetails;
use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Prescription;
use App\Models\Spending;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;

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

    public function showAll()
    {
        $bills = QueryBuilder::for(Bill::class)
            ->with('doctor')
            ->with('clinic')
            ->defaultSort('id')
            ->allowedSorts(['id', 'date', 'totalAmount'])
            ->allowedFilters(['date', 'doctor', 'clinic', 'totalAmount'])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();

        return Inertia::render('Bills/Index', [
            'bills' => $bills
        ])->table(function (InertiaTable $table) {
            $table->column(
                key: "id",
                label: __("ID"),
                canBeHidden: true,
                hidden: false,
                sortable: true
            )->column(
                key: "date",
                label: __("Date"),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "doctor",
                label: __("Doctor"),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "clinic",
                label: __("Clinic"),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "totalAmount",
                label: __("Total"),
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
        if ($request->clinic['id'] == -1 && $request->doctor['id'] == -1) {
            $doctor_prescriptions = Prescription::with('doctor')
                ->with('prescriptionItems')
                ->with('clinic')
                ->with('appointment')
                ->with('appointment.payment')
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
        } elseif ($request->clinic['id'] == -1) {
            $doctor_prescriptions = Prescription::with('doctor')
                ->with('prescriptionItems')
                ->with('clinic')
                ->with('appointment')
                ->with('appointment.payment')
                ->where('doctor_id', '=', $request->doctor['id'])
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
    }

    public function searchExpensesData(Request $request)
    {
        // dd($request);

        if ($request->doctor['id'] == -1 && $request->clinic['id'] == -1) {
            $bills = Bill::with('billDetails')
                ->with('doctor')
                ->with('clinic')
                ->whereBetween('date', [$request->startDate, $request->endDate])
                ->get();
        } elseif ($request->doctor['id'] == -1) {
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


    public function getItemsBalance(Request $request)
    {
        // dd($request);

        if ($request->clinic['id'] == -1 && $request->doctor['id'] == -1) {

            $items = Item::with('billDetails')
                ->with('spendings')
                ->get();

            // $bills = Item::with('billDetails')->with('spendings')->get();

            // Bill::with('billDetails')
            //     ->with('billDetails.item')
            //     ->with('doctor')
            //     ->with('clinic')
            //     ->whereBetween('date', [$request->startDate, $request->endDate])
            //     ->get();

            // $spendings = Spending::with('item')
            //     ->whereBetween('date_isseud', [$request->startDate, $request->endDate])
            //     ->get();
        } elseif ($request->doctor['id'] == -1) {

            $items = Item::with(['billDetails.bill' => function ($query) use ($request) {
                $query->where('clinic_id', '=', $request->clinic['id']);
            }])->with('billDetails')
                ->with('spendings')
                ->get();

            // $bills = Bill::with('billDetails')
            //     ->with('billDetails.item')
            //     ->with('doctor')
            //     ->with('clinic')
            //     ->where('clinic_id', '=', $request->clinic['id'])
            //     ->whereBetween('date', [$request->startDate, $request->endDate])
            //     ->get();
            // $spendings = Spending::with('item')
            //     ->where('clinic_id', '=', $request->clinic['id'])
            //     ->whereBetween('date_isseud', [$request->startDate, $request->endDate])
            //     ->get();
        } elseif ($request->clinic['id'] == -1) {

            $items = Item::with(['billDetails.bill' => function ($query) use ($request) {
                $query->where('doctor_id', '=', $request->doctor['id']);
            }])->with('billDetails')
                ->with('spendings')
                ->get();

            // $bills = Bill::with('billDetails')
            //     ->with('billDetails.item')
            //     ->with('doctor')
            //     ->with('clinic')
            //     ->where('doctor_id', '=', $request->doctor['id'])
            //     ->whereBetween('date', [$request->startDate, $request->endDate])
            //     ->get();

            // $spendings = Spending::with('item')
            //     ->where('doctor_id', '=', $request->doctor['id'])
            //     ->whereBetween('date_isseud', [$request->startDate, $request->endDate])
            //     ->get();
        } else {

            $items = Item::with('billDetails')
            ->with('spendings')
            ->with(['billDetails.bill' => function ($query) use ($request) {
                $query->where('doctor_id', '=', $request->doctor['id']);
                $query->where('clinic_id', '=', $request->clinic['id']);
            }])->get();

            // $bills = Bill::with('billDetails')
            //     ->with('billDetails.item')
            //     ->with('doctor')
            //     ->with('clinic')
            //     ->where('doctor_id', '=', $request->doctor['id'])
            //     ->where('clinic_id', '=', $request->clinic['id'])
            //     ->whereBetween('date', [$request->startDate, $request->endDate])
            //     ->get();
            // $spendings = Spending::with('item')
            //     ->where('doctor_id', '=', $request->doctor['id'])
            //     ->where('clinic_id', '=', $request->clinic['id'])
            //     ->whereBetween('date_isseud', [$request->startDate, $request->endDate])
            //     ->get();
        }
        return $items;
    }
}
