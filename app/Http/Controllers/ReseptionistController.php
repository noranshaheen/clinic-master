<?php

namespace App\Http\Controllers;

use App\Models\Reseptionist;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ReseptionistController extends Controller
{

    public function index()
    {
        $reseptionists = QueryBuilder::for (Reseptionist::class)
        ->defaultSort('id')
        ->allowedSorts(['id','name','date_of_birth'])
        ->allowedFilters(['name','phone','date_of_birth','gender'])
        ->paginate(Request()->input('perPage',20))
        ->withQueryString();

        return Inertia::render('Reseptionists/Index', [
            'reseptionists' => $reseptionists
        ])->table(function (InertiaTable $table) {
            $table->column(
                key:"id",
                label:__("ID"),
                canBeHidden:false,
                hidden:false,
                sortable:true,
            )->column(
                key:"name",
                label: __("Name"),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"gender",
                label: __("Gender"),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"date_of_birth",
                label: __("Age"),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"phone",
                label: __("Phone Number"),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"actions",
                label: __("Actions"),
            );
        });
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $today = Carbon::parse('today');

        $request->validate([
            'name' =>['string','max:255','min:2','required','regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'phone' =>['numeric','min:11','required','unique:reseptionists,phone'],
            'gender' =>['required',Rule::in(['M','F'])],
            'date_of_birth' => ['date','required','before_or_equal:'.$today],
        ]);

        $patient = new Reseptionist();
        $patient->name = $request->name;
        $patient->phone = $request->phone;
        $patient->gender = $request->gender;
        $patient->date_of_birth = $request->date_of_birth;
        $patient->save();
    }

    public function show(Patient $patient)
    {
        //
    }

    public function edit(Patient $patient)
    {
        //
    }

    public function update(Request $request, Patient $patient)
    {
        $today = Carbon::parse('today');

        $date =  $request->validate([
            'name' =>['string','max:255','min:2','required','regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'phone' =>['numeric','min:11','required','unique:patients,phone'],
            'gender' =>['required',Rule::in(['M','F'])],
            'date_of_birth' => ['date','required','before_or_equal:'.$today],
        ]);

        $patient->update($date);
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
    }

    public function all(){
        return Reseptionist::all();
    }
}
