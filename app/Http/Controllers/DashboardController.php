<?php

namespace App\Http\Controllers;

use App\Models\ETA\Invoice;
use Carbon\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // $firstDayOfLastWeek = now()->subWeek()->toDateString();

        // $today = now()->toDateString();

        // $firstDayOfTheLastMonth = now()->startOfMonth()->subMonth()->toDateString();

        // $lastDayOfTheLastMonth = Carbon::parse('last day of last month')->toDateString();

        // $firstDayOfTheCurrentMonth = now()->startOfMonth()->toDateString();

        // $lastDayOfTheCurrentMonth = now()->lastOfMonth()->toDateString();

        return Inertia::render('Dashboard/index');
    }
}
