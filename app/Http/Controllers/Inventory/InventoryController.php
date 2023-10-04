<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Inventory;
use App\Models\Inventory\InvStock;
use App\Models\Inventory\StockMovement;
use App\Models\Inventory\StockTotalItems;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Traits\ExcelWrapper;

class InventoryController extends Controller
{

    use ExcelWrapper;
    public function index()
    {
        $inventories = QueryBuilder::for(Inventory::class)
            ->with('clinic')
            ->with('stocks')
            ->defaultSort('id')
            ->allowedSorts(['id', 'name', 'location', 'clinic_id'])
            ->allowedFilters(['name', 'location', 'clinic.name'])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();

        return Inertia::render('Inventories/Index', [
            'inventories' => $inventories
        ])->table(function (InertiaTable $table) {
            $table->column(
                key: "id",
                label: __("ID"),
                canBeHidden: false,
                hidden: false,
                sortable: true
            )
                ->column(
                    key: "name",
                    label: __("Name"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    key: "location",
                    label: __("Address"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    key: "clinic.name",
                    label: __("Clinic"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
                )->column(
                    key: "actions",
                    label: __("Actions")
                );
        });
    }

    //show total items in inventories
    public function showItems()
    {
        // dd('show items');
        $items = QueryBuilder::for(StockTotalItems::class)
            ->with('item')
            ->with('stock')
            ->with('stock.inventory')
            ->with('stock.inventory.clinic')
            ->defaultSort('id')
            ->allowedSorts(['id', 'quantity_in_hand'])
            ->allowedFilters(['quantity_in_hand', 'item.name', 'stock.name', 'stock.inventory.name', 'stock.inventory.clinic.name'])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();

        return Inertia::render('Inventories/Items', [
            'items' => $items
        ])->table(function (InertiaTable $table) {
            $table->column(
                key: "id",
                label: __("ID"),
                canBeHidden: false,
                hidden: false,
                sortable: true
            )
                ->column(
                    key: "item.name",
                    label: __("Item"),
                    canBeHidden: true,
                    hidden: false,
                    // sortable: true,
                    searchable: true
                )
                ->column(
                    key: "quantity_in_hand",
                    label: __("Quantity"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    key: "stock.name",
                    label: __("Stock"),
                    canBeHidden: true,
                    hidden: false,
                    // sortable: true,
                    searchable: true
                )
                ->column(
                    key: "stock.inventory.name",
                    label: __("Warehouse"),
                    canBeHidden: true,
                    hidden: false,
                    // sortable: true,
                    searchable: true
                )
                ->column(
                    key: "stock.inventory.clinic.name",
                    label: __("Clinic"),
                    canBeHidden: true,
                    hidden: false,
                    // sortable: true,
                    searchable: true
                );
            // ->column(
            //     key: "clinic.name",
            //     label: __("Clinic"),
            //     canBeHidden: true,
            //     hidden: false,
            //     sortable: true,
            //     searchable: true
            // )->column(
            //     key: "actions",
            //     label: __("Actions")
            // );
        });
    }

    // stock ins movements
    public function showIns()
    {
        $in_movements = QueryBuilder::for(StockMovement::class)
            ->with('stock')
            ->with('stock.inventory')
            ->with('stock.inventory.clinic')
            ->with('item')
            ->where('type', '=', 'in')
            ->orderBy('date', 'desc')
            ->defaultSort('id')
            ->allowedSorts(['id', 'inv_stock_id', 'item_id', 'date', 'quantity', 'unit_price', 'total_price'])
            ->allowedFilters(['inv_stock_id', 'item_id', 'date', 'quantity', 'unit_price', 'total_price'])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();

        return Inertia::render('Inventories/Movements/IN/Index', [
            'in_movements' => $in_movements
        ])->table(function (InertiaTable $table) {
            $table->column(
                key: "id",
                label: __("ID"),
                canBeHidden: false,
                hidden: false,
                sortable: true
            )
                ->column(
                    key: "warehouse",
                    label: __("Warehouse"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    key: "clinic",
                    label: __("Clinic"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
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
                    key: "stock",
                    label: __("Stock"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    key: "type",
                    label: __("Movement"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    key: "item",
                    label: __("Item"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    key: "quantity",
                    label: __("Quantity"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    key: "unit_price",
                    label: __("Unit Price"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    key: "total_price",
                    label: __("Total Price"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
                );
            // ->column(
            //     key: "actions",
            //     label: "Actions"
            // );
        });
    }

    public function createIns()
    {
        return Inertia::render('Inventories/Movements/IN/Create');
    }

    public function storeIns(Request $request)
    {

        foreach ($request->billLines as $line) {

            // stock_movement talble
            $stock_in = new StockMovement();
            $stock_in->inv_stock_id = $request->stock['id'];
            $stock_in->date = $request->date;
            $stock_in->type = "in";
            $stock_in->item_id = $line['item']['id'];
            $stock_in->quantity = $line['quantity'];
            $stock_in->unit_price = $line['unitPrice'];
            $stock_in->total_price = $line['total'];
            $stock_in->save();

            // stock_items_total table
            $item = StockTotalItems::where('item_id', '=', $line['item']['id'])
                ->where('inv_stock_id', '=', $request->stock['id'])
                ->first();
            // dd($item);
            if (!$item) {
                $item2 = new StockTotalItems();
                $item2->inv_stock_id =  $request->stock['id'];
                $item2->item_id = $line['item']['id'];
                $item2->quantity_in_hand =  $line['quantity'];
                $item2->save();
            } else {
                $item->quantity_in_hand =  $item->quantity_in_hand + $line['quantity'];
                $item->save();
            }
        }
    }


    // stock outs movements
    public function showOuts()
    {
        $out_movements = QueryBuilder::for(StockMovement::class)
            ->with('stock')
            ->with('stock.inventory')
            ->with('stock.inventory.clinic')
            ->with('item')
            ->where('type', '=', 'out')
            ->orderBy('date', 'desc')
            ->defaultSort('id')
            ->allowedSorts(['id', 'inv_stock_id', 'item_id', 'date', 'quantity', 'unit_price', 'total_price'])
            ->allowedFilters(['inv_stock_id', 'item_id', 'date', 'quantity', 'unit_price', 'total_price'])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();

        return Inertia::render('Inventories/Movements/OUT/Index', [
            'out_movements' => $out_movements
        ])->table(function (InertiaTable $table) {
            $table->column(
                key: "id",
                label: __("ID"),
                canBeHidden: false,
                hidden: false,
                sortable: true
            )->column(
                key: "date",
                label: __("Date"),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )
                ->column(
                    key: "clinic",
                    label: __("Clinic"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    key: "warehouse",
                    label: __("Warehouse"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    key: "stock",
                    label: __("Stock"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    key: "type",
                    label: __("Movement"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    key: "item",
                    label: __("Item"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    key: "quantity",
                    label: __("Quantity"),
                    canBeHidden: true,
                    hidden: false,
                    sortable: true,
                    searchable: true
                );
            // ->column(
            //     key: "actions",
            //     label: "Actions"
            // );
        });
    }

    public function createOUTs()
    {
        return Inertia::render('Inventories/Movements/OUT/Create');
    }

    public function storeOUTs(Request $request)
    {
        $request->validate([
            "billLines"           => ['required', 'array', 'min:1'],
            "billLines.*.item"      => ['required'],
            "billLines.*.quantity"  => ['required', 'gt:0'],
            'clinic_id'             => ["required", 'exists:App\Models\Clinic,id'],
            "warehouse.id"             => ["required", 'exists:App\Models\Inventory\Inventory,id'],
            "stock.id"              => ["required", 'exists:App\Models\Inventory\InvStock,id'],
            "date"                  => ['required', 'date'],
            // "billLines.*.unitPrice" => ['required'],
            // "billLines.*.total"     => ['required'],
            // "billLines.*.unit"      => ['nullable'],
            // "billTotalAmount"       => ["required"]
        ]);

        foreach ($request->billLines as $line) {

            // stock_items_total table
            $item = StockTotalItems::where('item_id', '=', $line['item']['id'])
                ->where('inv_stock_id', '=', $request->stock['id'])
                ->first();
            if ((!$item) || ($item->quantity_in_hand == 0) || ($item->quantity_in_hand < $line['quantity'])) {
                // no items in stock !! 
                throw ValidationException::withMessages([
                    'error' => "no enough items in stock"
                ]);
            } elseif ($item->quantity_in_hand > $line['quantity']) {

                // stock_movement talble
                $stock_in = new StockMovement();
                $stock_in->inv_stock_id = $request->stock['id'];
                $stock_in->date = $request->date;
                $stock_in->type = "out";
                $stock_in->item_id = $line['item']['id'];
                $stock_in->quantity = "-" . $line['quantity'];
                // $stock_in->unit_price = $line['unitPrice'] ? $line['unitPrice'] : null;
                // $stock_in->total_price = $line['total'] ? $line['total'] : null;
                $stock_in->save();

                $item->quantity_in_hand =  $item->quantity_in_hand - $line['quantity'];
                $item->save();
            }
        }
        return "out movement is done successfully";
    }

    public function getAllInventories($clinic_id = null)
    {
        if ($clinic_id) {
            $clinic_inventories = Inventory::where('clinic_id', '=', $clinic_id)
                ->with('stocks')
                ->get();
            return $clinic_inventories;
        } else {
            $inventories = Inventory::with('stocks')
                ->get();
            return $inventories;
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ["required"],
            'address' => ["nullable", 'string', 'min:2', 'max:400'],
            'clinic_id' => ["required", 'exists:App\Models\Clinic,id'],
            'stocks' =>  ['required', 'array', 'min:1'],
            'stocks.*.name' =>  ['required'],

        ]);

        $inventory = new Inventory();
        $inventory->name = $request->name;
        $inventory->location = $request->address;
        $inventory->clinic_id = $request->clinic_id;
        $inventory->save();
        if (count($request->stocks)) {
            foreach ($request->stocks as $stock) {
                $stk = new InvStock();
                $stk->name = $stock['name'];
                $stk->inventory_id = $inventory->id;
                $stk->save();
            }
        }
    }

    public function getItemsBalance()
    {
        return Inertia::render('Bills/SearchItemsBalance');
    }

    public function searchItemsBalance(Request $request)
    {
        // dd($request);
        $stocks = InvStock::where('inventory_id', '=', $request->warehouse['id'])->get();
        $items = array();
        foreach ($stocks as $stock) {
            $stock_items = StockMovement::with('item')
                ->with('stock')
                ->where('inv_stock_id', '=', $stock->id)
                ->whereBetween('date', [$request->startDate, $request->endDate])
                ->get();

            foreach ($stock_items as $stk) {
                array_push($items, $stk);
            }
        }

        $collection = collect($items);
        $items = $collection->groupBy('item_id');
        return $items;
    }

    private function getTotal($item_movments, $type)
    {
        $total = 0;
        // $totalins = 0;
        foreach ($item_movments as $movement) {
            if ($movement['type'] == $type) {
                $total += $movement['quantity'];
            }
        }
        return $total;
    }

    public function exportItemsBalance(Request $request)
    {
        // dd($request);
        $stocks = InvStock::where('inventory_id', '=', $request->warehouse['id'])->get();
        $items = array();
        foreach ($stocks as $stock) {
            $stock_items = StockMovement::with('item')
                ->with('stock')
                ->where('inv_stock_id', '=', $stock->id)
                ->whereBetween('date', [$request->startDate, $request->endDate])
                ->get();

            foreach ($stock_items as $stk) {
                array_push($items, $stk);
            }
        }

        $collection = collect($items);
        $items = $collection->groupBy('item_id')->toArray();
        // $items = array($items);


        // dd($items);

        //render excel file now
        $reader = IOFactory::createReader('Xlsx');
        $file = $reader->load('./ExcelTemplates/InventoryBalance.xlsx');

        $rowIdx = 4;
        foreach ($items as $row) {

            $file->getActiveSheet()->setCellValue($this->index2(1, $rowIdx), $row[0]['item']['name']);
            $file->getActiveSheet()->setCellValue($this->index2(2, $rowIdx), $request->warehouse['name']);
            $file->getActiveSheet()->setCellValue($this->index2(3, $rowIdx), $request->clinic['name']);
            $file->getActiveSheet()->setCellValue($this->index2(4, $rowIdx), $this->getTotal($row, 'in'));
            $file->getActiveSheet()->setCellValue($this->index2(5, $rowIdx), $this->getTotal($row, 'out'));
            $file->getActiveSheet()->setCellValue($this->index2(6, $rowIdx), "=SUM(E" . $rowIdx . ":D" . $rowIdx . ")");
            $rowIdx++;
        }

        $writer = IOFactory::createWriter($file, 'Xlsx');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Purchase_ExportedData.xls"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, Inventory $inventory)
    {
        // dd($request , $inventory);

        $request->validate([
            'name' => ["required"],
            'address' => ["nullable", 'string', 'min:2', 'max:400'],
            'clinic_id' => ["required", 'exists:App\Models\Clinic,id'],
            'stocks' =>  ['required', 'array', 'min:1'],
            'stocks.*.name' =>  ['required'],
        ]);

        // $inventory = Inventory::findOrFail($id);

        $inventory->update([
            'name' => $request->name,
            'location' => $request->address,
            'clinic_id' => $request->clinic_id,
        ]);

        foreach ($request->stocks as $stock) {
            $stk = InvStock::where('name', '=', $stock['name'])
                ->where('inventory_id', '=', $inventory->id)
                ->first();
            if (!$stk) {
                $stk = new InvStock();
                $stk->name = $stock['name'];
                $stk->inventory_id = $inventory->id;
                $stk->save();
            }
        }
    }


    public function destroy(string $id)
    {
        $inventory = Inventory::findOrFail($id);

        $stocks = $inventory->stocks;

        foreach ($stocks as $stock) {
            $movements = StockMovement::where('inv_stock_id', '=', $stock['id'])->get();
            foreach ($movements as $mov) {
                $mov->delete();
            }

            $items = StockTotalItems::where('inv_stock_id', '=', $stock['id'])->get();
            foreach ($items as $item) {
                $item->delete();
            }

            $stock->delete();
        }
        $inventory->delete();
    }
}
