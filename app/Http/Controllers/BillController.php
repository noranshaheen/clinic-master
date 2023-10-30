<?php

namespace App\Http\Controllers;

use App\Exports\ReportIncomsExport;
use App\Models\Bill;
use App\Models\BillDetails;
use App\Models\Inventory\StockMovement;
use App\Models\Inventory\StockTotalItems;
use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Prescription;
use App\Models\Spending;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Traits\ExcelWrapper;
use Illuminate\Http\Client\Response;

class BillController extends Controller
{
    use ExcelWrapper;
    /**
     * Display a listing of the resource.
     */
    public function createAdministrativeBill()
    {
        return Inertia::render('Bills/Administrative/Create');
    }

    public function createPurchaseBill()
    {
        return Inertia::render('Bills/Purchase/Create');
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
    public function storeAdministrativeBill(Request $request)
    {
        // dd($request);
        $request->validate([
            "billLines"           => ['required', 'array', 'min:1'],
            "billLines.*.item"      => ['required'],
            "billLines.*.total"     => ['required', 'gt:0'],
            'clinic.id'             => ["required", 'exists:App\Models\Clinic,id'],
            "date"                  => ['required', 'date'],
            "billTotalAmount"       => ["required"]
        ]);

        $item = new Bill();
        // $item->doctor_id = $request->doctor['id'];
        $item->type = 'administrative';
        $item->clinic_id = $request->clinic['id'];
        $item->date = $request->date;
        $item->totalAmount = $request->billTotalAmount;
        $item->save();

        foreach ($request->billLines as $line) {
            $item2 = new BillDetails();
            $item2->item_id = $line['item']['id'];
            $item2->total = $line['total'];
            $item2->date = $request->date;
            $item2->bill_id = $item->id;
            $item2->save();

            // $item->billDetails()->save($item2);
            // $item2->price = $line['unitPrice'];
            // $item2->quantity = $line['quantity'];
        }
    }


    public function storePurchaseBill(Request $request)
    {
        // dd($request);

        $request->validate([
            "billLines"           => ['required', 'array', 'min:1'],
            "billLines.*.item"      => ['required'],
            "billLines.*.unit"      => ['nullable'],
            "billLines.*.unitPrice" => ['required'],
            "billLines.*.quantity"  => ['required', 'gt:0'],
            "billLines.*.total"     => ['required'],
            'clinic_id'             => ["required", 'exists:App\Models\Clinic,id'],
            "warehouse.id"             => ["required", 'exists:App\Models\Inventory\Inventory,id'],
            "stock.id"              => ["required", 'exists:App\Models\Inventory\InvStock,id'],
            "date"                  => ['required', 'date'],
            "billTotalAmount"       => ["required"]
        ]);

        $item = new Bill();
        // $item->doctor_id = $request->doctor['id'];
        $item->type = 'purchase';
        $item->clinic_id = $request->clinic_id;
        $item->date = $request->date;
        $item->totalAmount = $request->billTotalAmount;
        $item->save();

        foreach ($request->billLines as $line) {
            $item2 = new BillDetails();
            $item2->item_id = $line['item']['id'];
            $item2->price = $line['unitPrice'];
            $item2->quantity = $line['quantity'];
            $item2->total = $line['total'];
            $item2->date = $request->date;
            // $item2->save();
            $item->billDetails()->save($item2);

            //store item in stok
            $stok_in = new StockMovement();
            $stok_in->inv_stock_id = $request->stock['id'];
            $stok_in->item_id = $line['item']['id'];
            $stok_in->date = $request->date;
            $stok_in->type = 'in';
            $stok_in->quantity = $line['quantity'];
            $stok_in->unit_price = $line['unitPrice'];
            $stok_in->total_price = $line['total'];
            $stok_in->save();

            $items_in_stock = StockTotalItems::where('item_id', '=', $line['item']['id'])
                ->where('inv_stock_id', '=', $request->stock['id'])
                ->first();
            if (!$items_in_stock) {
                $items_in_stock2 = new StockTotalItems();
                $items_in_stock2->inv_stock_id =  $request->stock['id'];
                $items_in_stock2->item_id = $line['item']['id'];
                $items_in_stock2->quantity_in_hand =  $line['quantity'];
                $items_in_stock2->save();
            } else {
                $items_in_stock->quantity_in_hand =  $items_in_stock->quantity_in_hand + $line['quantity'];
                $items_in_stock->save();
            }
        }
    }

    public function showAll()
    {
        $bills = QueryBuilder::for(Bill::class)
            // ->with('doctor')
            ->with('clinic')
            ->defaultSort('id')
            ->allowedSorts(['id', 'type', 'date', 'clinic', 'totalAmount'])
            ->allowedFilters(['date', 'type', 'clinic', 'totalAmount'])
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
            )
                ->column(
                    key: "date",
                    label: __("Date"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    key: "type",
                    label: __("Type"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
                )
                // ->column(
                //     key: "doctor",
                //     label: __("Doctor"),
                //     canBeHidden: true,
                //     hidden: false,
                //     sortable: true,
                //     searchable: true
                // )
                ->column(
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


    public function search()
    {
        return Inertia::render(
            'Bills/Search'
        );
    }

    public function searchIncomes()
    {
        return Inertia::render(
            'Bills/SearchIncomes'
        );
    }
    public function searchTotalIncomes()
    {
        return Inertia::render(
            'Bills/SearchTotalIncomes'
        );
    }

    public function searchTotalIncomeData(Request $request)
    {
        if ($request->clinic['id'] == -1 && $request->doctor['id'] == -1) {

            $endDate = Carbon::parse($request->endDate)->endOfDay();

            $doctor_prescriptions = Prescription::with('doctor')
                ->with('prescriptionItems')
                ->with('clinic')
                ->with('patient')
                ->with('appointment')
                ->with('appointment.fees')
                ->with('appointment.payments')
                ->whereBetween('dateTimeIssued', [$request->startDate, $endDate])
                ->get();
            return $doctor_prescriptions;
        } elseif ($request->doctor['id'] == -1) {

            $endDate = Carbon::parse($request->endDate)->endOfDay();

            $doctor_prescriptions = Prescription::with('doctor')
                ->with('prescriptionItems')
                ->with('clinic')
                ->with('patient')
                ->with('appointment')
                ->with('appointment.fees')
                ->with('appointment.payments')
                ->where('clinic_id', '=', $request->clinic['id'])
                ->whereBetween('dateTimeIssued', [$request->startDate, $endDate])
                ->get();
            return $doctor_prescriptions;
        } elseif ($request->clinic['id'] == -1) {

            $endDate = Carbon::parse($request->endDate)->endOfDay();

            $doctor_prescriptions = Prescription::with('doctor')
                ->with('prescriptionItems')
                ->with('clinic')
                ->with('patient')
                ->with('appointment')
                ->with('appointment.fees')
                ->with('appointment.payments')
                ->where('doctor_id', '=', $request->doctor['id'])
                ->whereBetween('dateTimeIssued', [$request->startDate, $endDate])
                ->get();
            return $doctor_prescriptions;
        } else {

            $endDate = Carbon::parse($request->endDate)->endOfDay();

            $doctor_prescriptions = Prescription::with('doctor')
                ->with('prescriptionItems')
                ->with('clinic')
                ->with('patient')
                ->with('appointment')
                ->with('appointment.fees')
                ->with('appointment.payments')
                ->where('doctor_id', '=', $request->doctor['id'])
                ->where('clinic_id', '=', $request->clinic['id'])
                ->whereBetween('dateTimeIssued', [$request->startDate, $endDate])
                ->get();
            return $doctor_prescriptions;
        }
    }
    public function searchIncomeData(Request $request)
    {
        if ($request->clinic['id'] == -1 && $request->doctor['id'] == -1) {

            $endDate = Carbon::parse($request->endDate)->endOfDay();

            $doctor_prescriptions = Prescription::with('doctor')
                ->with('prescriptionItems')
                ->with('clinic')
                ->with('patient')
                ->with('appointment')
                ->with('appointment.payments')
                ->whereBetween('dateTimeIssued', [$request->startDate, $endDate])
                ->get();
            return $doctor_prescriptions;
        } elseif ($request->doctor['id'] == -1) {

            $endDate = Carbon::parse($request->endDate)->endOfDay();

            $doctor_prescriptions = Prescription::with('doctor')
                ->with('prescriptionItems')
                ->with('clinic')
                ->with('patient')
                ->with('appointment')
                ->with('appointment.payments')
                ->where('clinic_id', '=', $request->clinic['id'])
                ->whereBetween('dateTimeIssued', [$request->startDate, $endDate])
                ->get();
            return $doctor_prescriptions;
        } elseif ($request->clinic['id'] == -1) {

            $endDate = Carbon::parse($request->endDate)->endOfDay();

            $doctor_prescriptions = Prescription::with('doctor')
                ->with('prescriptionItems')
                ->with('clinic')
                ->with('patient')
                ->with('appointment')
                ->with('appointment.payments')
                ->where('doctor_id', '=', $request->doctor['id'])
                ->whereBetween('dateTimeIssued', [$request->startDate, $endDate])
                ->get();
            return $doctor_prescriptions;
        } else {

            $endDate = Carbon::parse($request->endDate)->endOfDay();

            $doctor_prescriptions = Prescription::with('doctor')
                ->with('prescriptionItems')
                ->with('clinic')
                ->with('patient')
                ->with('appointment')
                ->with('appointment.payments')
                ->where('doctor_id', '=', $request->doctor['id'])
                ->where('clinic_id', '=', $request->clinic['id'])
                ->whereBetween('dateTimeIssued', [$request->startDate, $endDate])
                ->get();
            return $doctor_prescriptions;
        }
    }

    private function getTotalLine($row)
    {
        $total = 0;
        if ($row['appointment']['payment'] !== null) {
            $total += $row['appointment']['payment']['detection_fees'];
            if ($row['appointment']['payment']['service_fees'] !== null) {
                $total += $row['appointment']['payment']['service_fees'];
            }
        }
        return $total;
    }

    public function exportIncomeData(Request $request)
    {
        $endDate = Carbon::parse($request->endDate)->endOfDay();
        $doctor_prescriptions = null;

        if ($request->clinic['id'] == -1 && $request->doctor['id'] == -1) {
            $doctor_prescriptions = Prescription::with('doctor')
                ->with('prescriptionItems')
                ->with('clinic')
                ->with('appointment')
                ->with('appointment.payment')
                ->whereBetween('dateTimeIssued', [$request->startDate, $endDate])
                ->get();
        } elseif ($request->doctor['id'] == -1) {
            $doctor_prescriptions = Prescription::with('doctor')
                ->with('prescriptionItems')
                ->with('clinic')
                ->with('appointment')
                ->with('appointment.payment')
                ->where('clinic_id', '=', $request->clinic['id'])
                ->whereBetween('dateTimeIssued', [$request->startDate, $endDate])
                ->get();
        } elseif ($request->clinic['id'] == -1) {
            $doctor_prescriptions = Prescription::with('doctor')
                ->with('prescriptionItems')
                ->with('clinic')
                ->with('appointment')
                ->with('appointment.payment')
                ->where('doctor_id', '=', $request->doctor['id'])
                ->whereBetween('dateTimeIssued', [$request->startDate, $endDate])
                ->get();
        } else {
            $doctor_prescriptions = Prescription::with('doctor')
                ->with('prescriptionItems')
                ->with('clinic')
                ->with('appointment')
                ->with('appointment.payment')
                ->where('doctor_id', '=', $request->doctor['id'])
                ->where('clinic_id', '=', $request->clinic['id'])
                ->whereBetween('dateTimeIssued', [$request->startDate, $endDate])
                ->get();
        }

        //render excel file now
        $reader = IOFactory::createReader('Xlsx');
        $file = $reader->load('./ExcelTemplates/Incomes.xlsx');

        $rowIdx = 4;
        foreach ($doctor_prescriptions as $row) {
            $file->getActiveSheet()->setCellValue($this->index(1, $rowIdx), $row['id']);
            $file->getActiveSheet()->setCellValue($this->index(2, $rowIdx), Carbon::parse($row['dateTimeIssued'])->format('Y-m-d'));
            $file->getActiveSheet()->setCellValue($this->index(3, $rowIdx), $row['clinic']['name']);
            $file->getActiveSheet()->setCellValue($this->index(4, $rowIdx), $row['doctor']['name']);
            $file->getActiveSheet()->setCellValue($this->index(5, $rowIdx), $this->getTotalLine($row));
            $rowIdx++;
        }

        $file->getActiveSheet()->mergeCells($this->index(1, $rowIdx) . ':' . $this->index(4, $rowIdx));
        $file->getActiveSheet()->setCellValue($this->index(1, $rowIdx), "الأجمالي");
        $file->getActiveSheet()->setCellValue($this->index(5, $rowIdx), "=SUM(E4:E" . $rowIdx-1 . ")");


        $writer = IOFactory::createWriter($file, 'Xlsx');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Purchase_ExportedData.xls"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }


    public function searchExpenses()
    {
        return Inertia::render(
            'Bills/SearchExpenses'
        );
    }

    public function searchExpensesData(Request $request)
    {
        // dd($request);
        if ($request->clinic['id'] == -1) {
            $bills = Bill::with('billDetails')
                ->with('clinic')
                ->whereBetween('date', [$request->startDate, $request->endDate])
                ->get();
        } else {
            $bills = Bill::with('billDetails')
                ->with('clinic')
                ->where('clinic_id', '=', $request->clinic['id'])
                ->whereBetween('date', [$request->startDate, $request->endDate])
                ->get();
        }
        return $bills;
    }

    public function exportExpensesData(Request $request){
        $bills = null;
        if ($request->clinic['id'] == -1) {
            $bills = Bill::with('billDetails')
                ->with('clinic')
                ->whereBetween('date', [$request->startDate, $request->endDate])
                ->get();
        } else {
            $bills = Bill::with('billDetails')
                ->with('clinic')
                ->where('clinic_id', '=', $request->clinic['id'])
                ->whereBetween('date', [$request->startDate, $request->endDate])
                ->get();
        }

                //render excel file now
                $reader = IOFactory::createReader('Xlsx');
                $file = $reader->load('./ExcelTemplates/Expenses.xlsx');
        
                $rowIdx = 4;
                foreach ($bills as $row) {
                    $file->getActiveSheet()->setCellValue($this->index(1, $rowIdx), $row['id']);
                    $file->getActiveSheet()->setCellValue($this->index(2, $rowIdx), Carbon::parse($row['date'])->format('Y-m-d'));
                    $file->getActiveSheet()->setCellValue($this->index(3, $rowIdx), $row['clinic']['name']);
                    $file->getActiveSheet()->setCellValue($this->index(4, $rowIdx), $row['type']=='purchase' ? 'فاتورة شراء':'فاتورة ادارية');
                    $file->getActiveSheet()->setCellValue($this->index(5, $rowIdx), $row['totalAmount']);
                    $rowIdx++;
                }
        
                $file->getActiveSheet()->mergeCells($this->index(1, $rowIdx) . ':' . $this->index(4, $rowIdx));
                $file->getActiveSheet()->setCellValue($this->index(1, $rowIdx), "الأجمالي");
                $file->getActiveSheet()->setCellValue($this->index(5, $rowIdx), "=SUM(E4:E" . $rowIdx-1 . ")");
        
        
                $writer = IOFactory::createWriter($file, 'Xlsx');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="Purchase_ExportedData.xls"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');


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
