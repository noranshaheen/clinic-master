<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Traits\ExcelWrapper;
use App\Models\Diagnosis;
use App\Models\Specialty;
use Illuminate\Support\Facades\DB;

class DrugController extends Controller
{
    use ExcelWrapper;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drugs = QueryBuilder::for(Drug::class)
            ->with('diagnosis')
            ->defaultSort('id')
            ->allowedSorts(['id', 'name'])
            ->allowedFilters(['name', 'description'])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();

        return Inertia::render('Drugs/Index', [
            'drugs' => $drugs
        ])->table(function (InertiaTable $table) {
            $table->column(
                key: "id",
                label: __("ID"),
                canBeHidden: true,
                hidden: false,
                sortable: true
            )->column(
                key: "name",
                label: __("Name"),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "description",
                label: __("Description"),
                canBeHidden: true,
                hidden: false,
                searchable: true
            )->column(
                key: "actions",
                label: __("Actions"),
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
        // dd($request);
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[\p{Arabic}A-Za-z0-9\s]+$/u'],
            'description' => ['nullable', 'string', 'max:255'],
            'diagnose.*.id' => ['required']
        ]);

        $drug = new Drug();
        $drug->name = $request->name;
        $drug->description = $request->description;
        $drug->save();
        foreach ($request->diagnose as $diagnose) {
            $drug->diagnosis()->attach($diagnose['id']);
        }
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
            'name' => ['required', 'string', 'max:255', 'regex:/^[\p{Arabic}A-Za-z\s]+$/u'],
            'description' => ['nullable', 'string', 'max:255']
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

    public function all()
    {
        return Drug::all();
    }

    public function UploadDrugs(Request $request)
    {
        $temp = [];
        $extension = $request->file->extension();
        if ($extension == 'xlsx' || $extension == 'xls')
            $temp = $this->xlsxToArray($request->file, $extension);
        elseif($extension == 'csv')
            $temp = $this->csvToArray($request->file);
        else
            return json_encode(["Error" => true, "Message" => __("Unsupported File Type!")]);

        foreach ($temp as $key => $value) {
            $speciality = $temp[$key]['spaeciality'];
            $diagnosis = [];
            for ($i = 1; $i <= 10; $i++) {
                if ($temp[$key]['diagnose ' . $i]) {
                    array_push($diagnosis, $temp[$key]['diagnose ' . $i]);
                } else {
                    continue;
                }
            }
            // dd($diagnosis);
            $drug = Drug::where('name', $temp[$key]['name'])->first();
            if (!$drug) {
                $drug = new Drug();
                $drug->name = $temp[$key]['name'];
                $drug->description = $temp[$key]['description'];
                $drug->save();

                foreach ($diagnosis as $val) {
                    $diagnose = Diagnosis::where('name','=', $val)->first();
                    if (!$diagnose) {
                        $spc = Specialty::where('name','=', $speciality)->first();
                        if (!$spc) {
                            $sp = new Specialty();
                            $sp->name = $speciality;
                            $sp->save();
                            $dgsn = new Diagnosis();
                            $dgsn->name = $val;
                            $dgsn->description = null;
                            $sp->diagnosis()->save($dgsn);
                            $drug->diagnosis()->attach($dgsn->id);
                        } else {
                            $dgsn = new Diagnosis();
                            $dgsn->name = $val;
                            $dgsn->description = null;
                            $dgsn->specialty_id = $spc->id;
                            $dgsn->save();
                            $drug->diagnosis()->attach($dgsn->id);
                        }
                    } else {
                        $drug->diagnosis()->attach($diagnose->id);
                    }
                }
            }else{
                $deleted = DB::table('diagnosis_drug')
                ->where('drug_id',$drug->id)                
                ->delete();

                foreach ($diagnosis as $val) {
                    $diagnose = Diagnosis::where('name','=', $val)->first();
                    if (!$diagnose) {

                        $spc = Specialty::where('name','=', $speciality)->first();
                        if (!$spc) {
                            $sp = new Specialty();
                            $sp->name = $speciality;
                            $sp->save();
                            $dgsn = new Diagnosis();
                            $dgsn->name = $val;
                            $dgsn->description = null;
                            $sp->diagnosis()->save($dgsn);
                            $drug->diagnosis()->attach($dgsn->id);
                        } else {
                            $dgsn = new Diagnosis();
                            $dgsn->name = $val;
                            $dgsn->description = null;
                            $dgsn->specialty_id = $spc->id;
                            $dgsn->save();
                            $drug->diagnosis()->attach($dgsn->id);
                        }

                    } else {
                        $drug->diagnosis()->attach($diagnose->id);
                    }
                }
            }
        }
    }
}
