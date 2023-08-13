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
        ->allowedSorts(['id','name','date_of_birth','phone','gender'])
        ->allowedFilters(['id','name','date_of_birth','phone','gender'])
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
                searchable:true
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

        $reseptionist = new Reseptionist();
        $reseptionist->name = $request->name;
        $reseptionist->phone = $request->phone;
        $reseptionist->gender = $request->gender;
        $reseptionist->date_of_birth = $request->date_of_birth;
        $reseptionist->save();
    }

    public function show(Reseptionist $reseptionist)
    {
        //
    }

    public function edit(Reseptionist $reseptionist)
    {
        //
    }

    public function update(Request $request, Reseptionist $reseptionist)
    {
        $today = Carbon::parse('today');

        $date =  $request->validate([
            'name' =>['string','max:255','min:2','required','regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'phone' =>['numeric','min:11','required','unique:patients,phone'],
            'gender' =>['required',Rule::in(['M','F'])],
            'date_of_birth' => ['date','required','before_or_equal:'.$today],
        ]);

        $reseptionist->update($date);
    }

    public function destroy(Reseptionist $reseptionist)
    {
        $reseptionist->delete();
    }

    public function all(){
        return Reseptionist::all();
    }
}
