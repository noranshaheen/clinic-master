<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function index()
    {
        $sp = DB::table('specialities')->get();
        return $sp;
    }
}
