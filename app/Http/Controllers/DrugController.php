<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;

class DrugController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drugs = QueryBuilder::for (Drug::class)
        ->defaultSort('id')
        ->allowedSorts(['id','name'])
        ->allowedFilters(['name','description'])
        ->paginate(Request()->input('perPage',20))
        ->withQueryString();

        return Inertia::render('Drugs/Index', [
            'drugs' => $drugs
        ])->table(function (InertiaTable $table) {
            $table->column(
                key:"id",
                label:__("ID"),
                canBeHidden:true,
                hidden:false,
                sortable:true
            )->column(
                key:"name",
                label:__("Name"),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"description",
                label:__("Description"),
                canBeHidden:true,
                hidden:false,
                searchable:true
            )->column(
                key:"actions",
                label:__("Actions"),
            );
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>['required','string','max:255'],
            'description' =>['nullable','string','max:255']
        ]);

        $drug = new Drug();
        $drug->name = $request->name;
        $drug->description = $request->description;
        $drug->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Drug $drug)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Drug $drug)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Drug $drug)
    {
        $data = $request->validate([
            'name' =>['required','string','max:255'],
            'description' =>['nullable','string','max:255']
        ]);

        $drug->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Drug $drug)
    {
        $drug->delete();
    }

    public function all(){
        return Drug::all();
    }
}
