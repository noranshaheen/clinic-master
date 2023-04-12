<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Accounting\AccountingActivity;
use PhpOffice\PhpSpreadsheet\IOFactory;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

use App\Http\Traits\ExcelWrapper;

class AccountingActivityController extends Controller
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

        $items = QueryBuilder::for(AccountingActivity::class)
            ->defaultSort('id')
            ->allowedSorts(['id', 'name', 'description', 'status'])
            ->allowedFilters(['id', 'name', 'description', $globalSearch])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();

        return Inertia::render('Accounting/Activity/Index', [
            'items' => $items,
        ])->table(function (InertiaTable $table) {
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
                key: 'description',
                label: __('Description'),
                canBeHidden: true,
                hidden: false,
                sortable: true
            )->column(
                key: 'status',
                label: __('Status'),
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
                key: 'status',
                label: __('Status')
            );
        });
    }

    public function index_json(Request $request)
    {
        return json_encode(AccountingActivity::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id'            => 'required',
            'name'          => 'required',
            'description'   => 'required',
            'status'        => 'required',
        ]);

        $item = AccountingActivity::updateOrCreate(
            ['id' => $data['id']],
            [
                'name'          => $data['name'],
                'description'   => $data['description'],
                'status'        => $data['status']
            ]
        );

        return json_encode(["Error" => false, "Message" => __("Data Saved Successfully!")]);
    }

    public function delete(Request $request)
    {
        $data = $request->validate([
            'id' => 'required'
        ]);

        $item = AccountingActivity::where('id', $data['id'])->first();
        $item->delete();

        return json_encode(["Error" => false, "Message" => __("Data Saved Successfully!")]);
    }
}