<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use App\Models\Diagnosis;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use App\Models\Specialty;
use App\Http\Traits\ExcelWrapper;



class AnalysisController extends Controller
{
    use ExcelWrapper;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
            'name' => ['string','max:255','min:2','required','regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'description' => ['string','max:255','min:2','nullable','regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'specialty_id' => ['required','exists:App\Models\Specialty,id']
        ]);
        $analysis = new Analysis();
        $analysis->name = $request->name;
        $analysis->description = $request->desc;
        $analysis->specialty_id = $request->specialty_id;
        $analysis->save();
    }


    public function UploadAnalysis(Request $request)
    {
        $temp = [];
        $extension = $request->file->extension();
        if ($extension == 'xlsx' || $extension == 'xls')
            $temp = $this->xlsxToArray($request->file, $extension);
        elseif ($extension == 'csv')
            $temp = $this->csvToArray($request->file);
        else
            return json_encode(["Error" => true, "Message" => __("Unsupported File Type!")]);


        foreach ($temp as $key => $value) {
            $speciality = $temp[$key]['spaeciality'];

            $analysis = Analysis::where('name','=',$temp[$key]['name'])->first();
            if(!$analysis){
                $spc = Specialty::where('name', '=', $speciality)->first();
                if(!$spc){
                    $sp = new Specialty();
                    $sp->name = $speciality;
                    $sp->save();
                    $analysis = new Analysis();
                    $analysis->name = $temp[$key]['name'];
                    $analysis->description = $temp[$key]['description'];
                    $analysis->specialty_id = $sp->id;
                    $analysis->save();
                }else{
                    $analysis = new Analysis();
                    $analysis->name = $temp[$key]['name'];
                    $analysis->description = $temp[$key]['description'];
                    $analysis->specialty_id = $spc->id;
                    $analysis->save();
                }
            }else{
                $spc = Specialty::where('name', '=', $speciality)->first();
                if(!$spc){
                    $sp = new Specialty();
                    $sp->name = $speciality;
                    $sp->save();
                    $analysis->name = $temp[$key]['name'];
                    $analysis->description = $temp[$key]['description'];
                    $analysis->specialty_id = $sp->id;
                    $analysis->save();
                }else{
                    $analysis->name = $temp[$key]['name'];
                    $analysis->description = $temp[$key]['description'];
                    $analysis->specialty_id = $spc->id;
                    $analysis->save();
                }

            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Analysis $analysis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Analysis $analysis)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Analysis $analysis)
    {
        $data = $request->validate([
            'name' => ['string','max:255','min:2','required','regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'description' => ['string','max:255','min:2','nullable','regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'specialty_id' => ['required','exists:App\Models\Specialty,id']
        ]);
        $analysis->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Analysis $analysis)
    {
        $analysis->delete();
    }

    public function allSpeciatlyAnalysis(){
        $doc = Doctor::find(Auth::user()->doc_res_id);
        $specialty_id = $doc->specialty_id;
        return Analysis::where('specialty_id','=',$specialty_id)->get();
    }
    // public function all(){
    //     return Diagnosis::with('drugs')->get();
    // }
}
