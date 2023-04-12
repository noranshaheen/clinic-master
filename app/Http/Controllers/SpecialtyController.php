<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function index()
    {
        $sp = DB::table('specialities')->get();
        return $sp;
    }
}
