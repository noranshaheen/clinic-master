<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\XRay;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ExcelWrapper;


class XRayController extends Controller
{
    use ExcelWrapper;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        $analysis = new XRay();
        $analysis->name = $request->name;
        $analysis->description = $request->description;
        $analysis->specialty_id = $request->specialty_id;
        $analysis->save();
    }

    public function UploadRays(Request $request)
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

            $ray = XRay::where('name','=',$temp[$key]['name'])->first();
            if(!$ray){
                $spc = Specialty::where('name', '=', $speciality)->first();
                if(!$spc){
                    $sp = new Specialty();
                    $sp->name = $speciality;
                    $sp->save();
                    $ray = new XRay();
                    $ray->name = $temp[$key]['name'];
                    $ray->description = $temp[$key]['description'];
                    $ray->specialty_id = $sp->id;
                    $ray->save();
                }else{
                    $ray = new XRay();
                    $ray->name = $temp[$key]['name'];
                    $ray->description = $temp[$key]['description'];
                    $ray->specialty_id = $spc->id;
                    $ray->save();
                }
            }else{
                $spc = Specialty::where('name', '=', $speciality)->first();
                if(!$spc){
                    $sp = new Specialty();
                    $sp->name = $speciality;
                    $sp->save();
                    $ray->name = $temp[$key]['name'];
                    $ray->description = $temp[$key]['description'];
                    $ray->specialty_id = $sp->id;
                    $ray->save();
                }else{
                    $ray->name = $temp[$key]['name'];
                    $ray->description = $temp[$key]['description'];
                    $ray->specialty_id = $spc->id;
                    $ray->save();
                }

            }
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, XRay $xray)
    {
        $data =  $request->validate([
            'name' => ['string','max:255','min:2','required','regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'description' => ['string','max:255','min:2','nullable','regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'specialty_id' => ['required','exists:App\Models\Specialty,id']
        ]);

        $xray->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function allSpeciatlyRays()
    {
        $doc = Doctor::find(Auth::user()->doc_res_id);
        $specialty_id = $doc->specialty_id;
        return XRay::where('specialty_id', '=', $specialty_id)->get();
    }
}
