<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Accounting\AccountingChart;
use PhpOffice\PhpSpreadsheet\IOFactory;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

use App\Http\Traits\ExcelWrapper;
use App\Models\Accounting\AccountingChartBalance;

class AccountingChartController extends Controller
{
    use ExcelWrapper;

    public function index(Request $request)
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                $query->where('id', 'LIKE', "%{$value}%")
                    ->orWhere('name', 'LIKE', "%{$value}%")
                    ->orWhere('description', 'LIKE', "%{$value}%");
            });
        });

        $items = QueryBuilder::for(AccountingChart::class)
            ->with("parent")
            ->with('balance')
            ->defaultSort('id')
            ->allowedSorts(['id', 'name', 'description', 'status'])
            ->allowedFilters(['id', 'name', 'parent_id', 'parent.id', 'description', 'visible_balance_sheet', 'visible_income_sheet', $globalSearch])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();

        return Inertia::render('Accounting/Chart/Index', [
            'items' => $items,
        ])->table(function (InertiaTable $table) {
            $table->withGlobalSearch();
            $table->column(
                key: 'id',
                label: __('Code'),
                canBeHidden: true,
                hidden: false,
                sortable: true
            )->column(
                key: 'name',
                label: __('Name'),
                canBeHidden: true,
                hidden: false,
                sortable: true
            )->column(
                key: 'parent.id',
                label: __('Parent Account Code'),
                canBeHidden: true,
                hidden: false,
                sortable: true
            )->column(
                key: 'parent.name',
                label: __('Parent Account Name'),
                canBeHidden: true,
                hidden: false,
                sortable: true
            )->column(
                key: 'description',
                label: __('Description'),
                canBeHidden: true,
                hidden: false,
                sortable: true
            )->column(
                key: 'visible_balance_sheet',
                label: __('Balance Sheet'),
                canBeHidden: true,
                hidden: false,
                sortable: true
            )->column(
                key: 'visible_income_sheet',
                label: __('Income Statement'),
                canBeHidden: true,
                hidden: false,
                sortable: true
            )->column(
                key: 'latest_balance.debit_amount',
                label: __('Debit Balance'),
                canBeHidden: true,
                hidden: false,
                sortable: true
            )->column(
                key: 'latest_balance.credit_amount',
                label: __('Credit Balance'),
                canBeHidden: true,
                hidden: false,
                sortable: true
            )->column(
                key: 'actions',
                label: __('Actions')
            )->searchInput(
                key: 'id',
                label: __('Code')
            )->searchInput(
                key: 'name',
                label: __('Name')
            )->searchInput(
                key: 'parent.id',
                label: __('Parent Account Code')
            )->searchInput(
                key: 'parent.name',
                label: __('Parent Account Name')
            )->selectFilter(
                key: 'visible_balance_sheet',
                options: [1 => __("Active"), 0 => __("Inactive")],
                label: __('Balance Sheet'),
                noFilterOption: true,
                noFilterOptionLabel: __('All')
            )->selectFilter(
                key: 'visible_income_sheet',
                options: [1 => __("Active"), 0 => __("Inactive")],
                label: __('Income Statement'),
                noFilterOption: true,
                noFilterOptionLabel: __('All')
            );
        });
    }

    public function index_json(Request $request)
    {
        return json_encode(AccountingChart::all());
    }

    public function upload(Request $request)
    {
        $temp = [];
        $extension = $request->file->extension();
        if ($extension == 'xlsx' || $extension == 'xls')
            $temp = $this->xlsxToArray($request->file, $extension);
        else if ($extension == 'csv')
            $temp = $this->csvToArray($request->file);
        else
            return json_encode(["Error" => true, "Message" => __("Unsupported File Type!")]);

        //clear all data in table
        AccountingChartBalance::truncate();
        AccountingChart::truncate();

        foreach ($temp as $chart) {
            $account = AccountingChart::updateOrCreate(
                ['id' => $chart['id']],
                $chart
            );
            $account->balance()->delete();
            $balance = new AccountingChartBalance($chart);
            $balance->balance_date = $this->excelDateToDatetime($chart['balance_date']);
            $balance->accounting_chart_id = $chart['id'];
            $balance->save();

        }
        return json_encode(["Error" => false, "Message" => __("Data Imported Successfully!")]);
    }

    public function download(Request $request)
    {
        $data = AccountingChart::all();

        //render excel file now
        $reader = IOFactory::createReader('Xlsx');
        $file = $reader->load('./ExcelTemplates/AccountingChart.xlsx');
        $rowIdx = 3;
        foreach ($data as $row) {
            $file->getActiveSheet()->setCellValue($this->index2(1, $rowIdx), $row->id);
            $file->getActiveSheet()->setCellValue($this->index2(2, $rowIdx), $row->name);
            $file->getActiveSheet()->setCellValue($this->index2(3, $rowIdx), $row->parent_id);
            $file->getActiveSheet()->setCellValue($this->index2(4, $rowIdx), $row->description);
            $file->getActiveSheet()->setCellValue($this->index2(5, $rowIdx), $row->status);
            $file->getActiveSheet()->setCellValue($this->index2(6, $rowIdx), $row->visible_balance_sheet ? '1' : '0');
            $file->getActiveSheet()->setCellValue($this->index2(7, $rowIdx), $row->visible_income_sheet ? '1' : '0');
            //get newest balance
            $balance = $row->balance->sortByDesc('balance_date')->first();
            if ($balance){
                $file->getActiveSheet()->setCellValue($this->index2(8, $rowIdx), $balance->balance_date);
                $file->getActiveSheet()->setCellValue($this->index2(9, $rowIdx), $balance->debit);
                $file->getActiveSheet()->setCellValue($this->index2(10, $rowIdx), $balance->credit);
                $file->getActiveSheet()->setCellValue($this->index2(11, $rowIdx), $balance->transferable ? '1' : '0');
            } else {
                $file->getActiveSheet()->setCellValue($this->index2(8, $rowIdx), '');
                $file->getActiveSheet()->setCellValue($this->index2(9, $rowIdx), '0');
                $file->getActiveSheet()->setCellValue($this->index2(10, $rowIdx), '0');
                $file->getActiveSheet()->setCellValue($this->index2(11, $rowIdx), '0');

            }
            $rowIdx++;
        }
        $writer = IOFactory::createWriter($file, 'Xlsx');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="accounting_chart.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id'                    => 'required',
            'name'                  => 'required',
            'parent_id'             => 'present',
            'description'           => 'required',
            'status'                => 'required',
            'visible_balance_sheet' => 'present|boolean',
            'visible_income_sheet'  => 'present|boolean',
            'balance.*.balance_date'    => 'date',
            'balance.*.debit'           => 'numeric',
            'balance.*.credit'          => 'numeric',
            'balance.*.transferable'    => 'present|boolean',
        ]);

        $item = AccountingChart::updateOrCreate(
            ['id' => $data['id']],
            [
                'name'          => $data['name'],
                'parent_id'     => $data['parent_id'],
                'description'   => $data['description'],
                'status'        => $data['status'],
                'visible_balance_sheet' => $data['visible_balance_sheet'] ? 1 : 0,
                'visible_income_sheet'  => $data['visible_income_sheet'] ? 1 : 0,
            ]
        );

        $item->balance()->delete();
        if (isset($data['balance']))
            foreach ($data['balance'] as $key => $line) {
                $balance = new AccountingChartBalance($line);
                $balance->accounting_chart_id = $item->id;
                $balance->transferable = $line['transferable'] ? 1 : 0;
                $balance->save();
            }

        return json_encode(["Error" => false, "Message" => __("Data Saved Successfully!")]);
    }

    public function delete(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        $item = AccountingChart::where('id', $data['id'])->first();
        $item->status = $data['status'];
        $item->save();

        return json_encode(["Error" => false, "Message" => __("Data Saved Successfully!")]);
    }
}
