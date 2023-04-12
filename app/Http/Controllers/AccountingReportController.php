<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

use App\Models\Accounting\AccountingChart;
use App\Models\Accounting\AccountingChartBalance;
use App\Models\Accounting\AccountingBook;
use App\Models\Accounting\AccountingBookData;
use App\Models\Accounting\AccountingBookDataDetails;

class AccountingReportController extends Controller
{
    public function review_index(Request $request)
    {
        $review_date = $request->input('start_date', "2022-12-31");
        $review_date = Carbon::parse($review_date)->format('Y-m-d');
        $review_date = Carbon::parse($review_date)->endOfDay();

        $items = AccountingChart::with('balance')->get();
        $items = $items->filter(function ($item) {
            return $item->visible_balance_sheet;
        });
        $items = $items->map(function ($item) use ($review_date) {
            $latest_balance = $item->balance->where('balance_date', '<=', $review_date)
                        ->sortByDesc('balance_date')->first();
            if ($latest_balance && ($latest_balance->debit > 0 || $latest_balance->credit > 0)) {
                $item->credit_amount = $latest_balance->credit;
                $item->debit_amount = $latest_balance->debit;
                $item->opening_balance_date = $latest_balance->balance_date;
            } else {
                return null;
            }            
            return $item;
        });
        //remove null items
        $items = $items->filter(function ($item) {
            return $item != null;
        });
        //find total credit and debit in items
        $total_credit = $items->sum('credit_amount');
        $total_debit = $items->sum('debit_amount');
        //add net profit item
        $net_profit = $total_debit - $total_credit;
        
        return Inertia::render('Accounting/Reports/ReviewSheet', [
            'items' => $items,
            'total_credit' => $total_credit,
            'total_debit' => $total_debit,
            'net_profit' => $net_profit
        ]);
    }

    public function balance_index(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $start_date = Carbon::parse($start_date)->format('Y-m-d');
        $end_date = Carbon::parse($end_date)->format('Y-m-d');
        $items = AccountingChart::with('balance')->get();
        $items = $items->filter(function ($item) {
            return $item->visible_balance_sheet;
        });
        $items = $items->map(function ($item) use ($start_date, $end_date) {
            $latest_balance = $item->balance->where('balance_date', '>=', $start_date)
                        ->where('balance_date', '<=', $end_date)->sortByDesc('balance_date')->first();
            if ($latest_balance) {
                $item->credit_amount = $latest_balance->sum('credit_amount');
                $item->debit_amount = $latest_balance->sum('debit_amount');
                $item->opening_balance_date = $latest_balance->balance_date;
            } else {
                return null;
                $item->credit_amount = 0;
                $item->debit_amount = 0;
                $item->opening_balance_date = $start_date;
            }            
            return $item;
        });
        dd(json_encode($items));
        //$unvisible = ["Name" => __("Net Profit"), "credit_amount"=> 0, "debit_amount"=> 0];

        // get all accounts with no parent
        //$items = AccountingChart::all();
        
        
        return Inertia::render('Accounting/Reports/BalanceSheet', [
            'items' => $items,
        ]);
    }

    //unit test for balance_index function
    public function test_balance_index(){
        $request = new Request();
        $request->start_date = '2021-01-01';
        $request->end_date = '2021-12-31';
        $response = $this->balance_index($request);
        //print $response;
    }

    public function income_statement_index()
    {
        return Inertia::render('Accounting/Reports/IncomeStatement', [
            'items' => $items,
        ]);
    }
}
