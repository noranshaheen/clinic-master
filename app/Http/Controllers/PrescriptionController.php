<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\PrescriptionItems;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;


class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prescriptions = QueryBuilder::for (Prescription::class)
            ->with('doctor')
            ->with('patient')
            ->with('prescriptionItems')
            ->allowedSorts(['id', 'dateTimeIssued'])
            ->allowedFilters(['dateTimeIssued'])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();

        return Inertia::render('Prescriptions/Index',
            ['prescriptions' => $prescriptions]
        )->table(function (InertiaTable $table) {
            $table->column(
                key:"id",
                label:"ID",
                canBeHidden:true,
                hidden:false,
                sortable:true
            )->column(
                key:"doctor",
                label:"Doctor",
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"patient",
                label:"Patient",
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"dateTimeIssued",
                label:"Date",
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"actions",
                label:"Actions",
            );
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Prescriptions/Add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $prescription = new Prescription();
        $prescription->patient_id = $request->patient['id'];
        $prescription->dateTimeIssued = $request->dateTimeIssued;
        $prescription->save();

        for ($i = 0; $i < count($request->prescriptionLines); $i++) {
            $prescriptionItem = new PrescriptionItems();
            $prescriptionItem->drug_id = $request->prescriptionLines[$i]['drug']['id'];
            $prescriptionItem->notes =
                $request->prescriptionLines[$i]['dose'] . " time/s per "
                . $request->prescriptionLines[$i]['time'] . " "
                . $request->prescriptionLines[$i]['notes'];
            $prescription->prescriptionItems()->save($prescriptionItem);
        }


    }
    /**
     * Display the specified resource.
     */
    public function show(Prescription $prescription)
    {
        //
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
        $PIs=$prescription->prescriptionItems;
        // $pi[0]->delete();
        // if (!is_array($PIs))
		// 	$PIs = [$PIs];
        for ($i = 0; $i < count($PIs);$i++){
            $PIs[$i]->delete();
        }
        $prescription->delete();
    }
}