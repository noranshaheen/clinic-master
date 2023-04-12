<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Accounting\AccountingBook;
use App\Models\Accounting\AccountingBookData;
use App\Models\Accounting\AccountingBookDataDetails;
use App\Models\Accounting\AccountingBookDataActivity;
use PhpOffice\PhpSpreadsheet\IOFactory;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

use App\Http\Traits\ExcelWrapper;


class AccountingBookController extends Controller
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

        $items = QueryBuilder::for(AccountingBook::class)
            ->defaultSort('id')
            ->allowedSorts(['id', 'name', 'description', 'status'])
            ->allowedFilters(['id', 'name', 'description', $globalSearch])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();

        return Inertia::render('Accounting/Book/Index', [
            'items' => $items,
        ])->table(function (InertiaTable $table) {
            $table->column(
                key: 'code',
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
                key: 'code',
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
        return json_encode(AccountingBook::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'          => 'required',
            'name'          => 'required',
            'description'   => 'required',
            'status'        => 'required',
        ]);

        $item = AccountingBook::updateOrCreate(
            ['code' => $data['code']],
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
            'code' => 'required'
        ]);

        $item = AccountingBook::where('code', $data['code'])->first();
        $item->delete();

        return json_encode(["Error" => false, "Message" => __("Data Saved Successfully!")]);
    }


    public function index_item(Request $request, AccountingBook $book)
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                $query->where('name', 'LIKE', "%{$value}%")
                    ->orWhere('description', 'LIKE', "%{$value}%");
            });
        });

        $items = QueryBuilder::for(AccountingBookData::class)
            ->with('entries')
            ->with('entries.account')
            ->with('activities')
            ->defaultSort('id')
            ->allowedSorts([
                'id', 'name', 'description', 'reference_code', 'transaction_date', 'debit', 'credit',
                'approved_by', 'accepted_by', 'rejected_by', 'rejection_reason', 'status'
            ])
            ->allowedFilters(['id', 'name', 'description', $globalSearch])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();

        return Inertia::render('Accounting/Book/IndexItem', [
            'items' => $items,
            'book' => $book
        ])->table(function (InertiaTable $table) {
            $table->column(
                key: 'reference_code',
                label: __('Book Reference Code'),
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
                key: 'transaction_date',
                label: __('Transaction Date'),
                canBeHidden: true,
                hidden: false,
                sortable: true
            )->column(
                key: 'debit',
                label: __('Debit Amount'),
                canBeHidden: true,
                hidden: false,
                sortable: true
            )->column(
                key: 'credit',
                label: __('Credit Amount'),
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
                key: 'reference_code',
                label: __('Book Reference Code')
            )->searchInput(
                key: 'name',
                label: __('Name')
            )->searchInput(
                key: 'status',
                label: __('Status')
            );
        });
    }

    public function index_item_json(Request $request, AccountingBook $book)
    {
        return json_encode(AccountingBook::all());
    }

    public function store_item(Request $request, AccountingBook $book)
    {
        $data = $request->validate([
            'id'                                    => 'present',
            'name'                                  => 'required',
            'description'                           => 'required',
            'reference_code'                        => 'required',
            'transaction_date'                      => 'required',
            'debit'                                 => 'required',
            'credit'                                => 'required',
            'approved_by'                           => 'present',
            'status'                                => 'required',
            'entries.*.account.id'                  => 'present',
            'entries.*.debit'                       => 'numeric',
            'entries.*.credit'                      => 'numeric',
            'activities.*.contribution_percentage'  => 'present',
            'activities.*.accounting_activity_id'   => 'present',

        ]);

        $item = AccountingBookData::updateOrCreate(
            ['id' => $data['id']],
            [
                'name'               => $data['name'],
                'description'        => $data['description'],
                'reference_code'     => $data['reference_code'],
                'accounting_book_id' => $book->id,
                'transaction_date'   => $data['transaction_date'],
                'debit'              => $data['debit'],
                'credit'             => $data['credit'],
                'status'             => $data['status'],
            ]
        );

        $item->entries()->delete();
        foreach ($data['entries'] as $key => $line) {
            $entry = new AccountingBookDataDetails($line);
            $entry->accounting_book_data_id = $item->id;
            $entry->accounting_chart_id = $line['account']['id'];
            $entry->save();
        }

        $item->activities()->detach();
        foreach ($data['activities'] as $key => $line) {
            $activity = new AccountingBookDataActivity($line);
            $activity->accounting_book_data_id = $item->id;
            $activity->save();
        }

        if ($request->hasFile('attachment')) {
            $uuid = Str::uuid();
            $file = $request->file('attachment');
            $file->storeAs('public/uploads/', $uuid);
            $item->attachment = $uuid;
            $item->save();
        }
        
        return Redirect::back()->with([
            "Error" => false,
            "Message" => __("Data Saved Successfully!")
        ]);
    }

    public function delete_item(Request $request, AccountingBook $book)
    {
        $data = $request->validate([
            'id' => 'required'
        ]);

        $item = AccountingBookData::find($data['id'])->first();
        $item->entries()->delete();
        $item->activities()->detach();
        $item->delete();

        return json_encode(["Error" => false, "Message" => __("Data Saved Successfully!")]);
    }

    public function download_item_attachment(Request $request, AccountingBook $book, AccountingBookData $book_data)
    {
        return Storage::download('public/uploads/' . $book_data->attachment);
    }

    public function print_book_item2(Request $request, AccountingBook $book, AccountingBookData $book_data)
    {
        return view('accounting.book_item', compact('book_data'));
        $base_accounts = [];
        $item_idx = 1000000;
        $book_data->entries->each(function ($item) use (&$base_accounts, &$item_idx) {
            $iter = $item->account;
            $level = 0;
            while($iter != null) {
                if (!isset($base_accounts[$iter->id])) {
                    $base_accounts[$iter->id] = [
                        'id' => $iter->id,
                        'name' => $iter->name,
                        'debit' => $item->debit,
                        'credit' => $item->credit,
                        'level' => $iter->parent == null ? 99 : $level,
                    ];
                } else {
                    $base_accounts[$iter->id]['debit'] += $item->debit;
                    $base_accounts[$iter->id]['credit'] += $item->credit;
                }
                $iter = $iter->parent;
                $level++;
            }
        });
        //sort by level, credit, debit
        usort($base_accounts, function($a, $b) {
            if ($a['level'] == $b['level']) {
                if ($a['credit'] == $b['credit']) {
                    return $a['debit'] <=> $b['debit'];
                }
                return $b['credit'] <=> $a['credit'];
            }
            return $a['level'] <=> $b['level'];
        });
        
        return view('accounting.book_item', compact('book_data', 'base_accounts'));
    }

    public function print_book_item(Request $request, AccountingBook $book, AccountingBookData $book_data)
    {
        $base_accounts = [];
        return view('accounting.book_item', compact('book_data', 'base_accounts'));
        $debit_accounts = [];
        $credit_accounts = [];
        //filter $book_data->entries that have only debit
        $book_data->entries->each(function ($item) use (&$debit_accounts, &$credit_accounts) {
            if ($item->debit > 0) 
                $debit_accounts[] = $item;
            else
                $credit_accounts[] = $item;
        });
        //find the lowest common ancestor for all $debit_accounts
        $debit_accounts = collect($debit_accounts);
        $debit_accounts = $debit_accounts->map(function ($item) {
            $iter = $item->account;
            $level = 0;
            $path = [];
            while($iter != null) {
                $path[] = [
                    'id' => $iter->id,
                    'name' => $iter->name,
                    'debit' => $item->debit,
                    'credit' => $item->credit,
                    'level' => $level,
                ];
                $iter = $iter->parent;
                $level++;
            }
            return $path;
        });
        $debit_accounts = $debit_accounts->toArray();
        $debit_accounts = array_reverse($debit_accounts);
        $debit_accounts = array_reduce($debit_accounts, 'array_intersect_key', array_shift($debit_accounts));
        $debit_accounts = array_reverse($debit_accounts);
        //find the lowest common ancestor for all $credit_accounts
        $credit_accounts = collect($credit_accounts);
        $credit_accounts = $credit_accounts->map(function ($item) {
            $iter = $item->account;
            $level = 0;
            $path = [];
            while($iter != null) {
                $path[] = [
                    'id' => $iter->id,
                    'name' => $iter->name,
                    'debit' => $item->debit,
                    'credit' => $item->credit,
                    'level' => $level,
                ];
                $iter = $iter->parent;
                $level++;
            }
            return $path;
        });
        $credit_accounts = $credit_accounts->toArray();
        $credit_accounts = array_reverse($credit_accounts);
        $credit_accounts = array_reduce($credit_accounts, 'array_intersect_key', array_shift($credit_accounts));
        $credit_accounts = array_reverse($credit_accounts);
        dd($debit_accounts, $credit_accounts);
    }
}
