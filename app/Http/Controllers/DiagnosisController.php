<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;


class DiagnosisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $diagnosis = QueryBuilder::for (Diagnosis::class)
            ->with('specialty')
            ->defaultSort('id')
            ->allowedSorts(['id', 'name','description'])
            ->allowedFilters(['name'])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();
        return Inertia::render('Diagnosis/Index',[
            'diagnosis'=>$diagnosis
        ])->table(function (InertiaTable $table) {
            $table->column(
                key:"id",
                label:__("ID"),
                canBeHidden:false,
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
                sortable:true,
                searchable:true
            )->column(
                key:"specialty",
                label:__("Specialty"),
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"actions",
                label:__("Actions")
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
        $diagnose = new Diagnosis();
        $diagnose->name = $request->name;
        $diagnose->description = $request->description;
        $diagnose->specialty_id = $request->specialty_id;
        $diagnose->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Diagnosis $diagnosis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diagnosis $diagnosis)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Diagnosis $diagnosi)
    {
        $data = $request->validate([
            'name' => ['string','max:255','min:2','required','regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'description' => ['string','max:255','min:2','nullable','regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'specialty_id' => ['required']
        ]);
        $diagnosi->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diagnosis $diagnosis)
    {
        $diagnosis->delete();
    }

    public function allSpeciatlyDiagnosis(){
        $doc = Doctor::find(Auth::user()->doc_res_id);
        $specialty_id = $doc->specialty_id;
        return Diagnosis::with('drugs')->where('specialty_id','=',$specialty_id)->get();
    }
    public function all(){
        return Diagnosis::with('drugs')->get();
    }
}
