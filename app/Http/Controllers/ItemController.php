<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Item;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$items = Item::all();
        return $items;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $data=$request->validate([
        'name'=>['required', 'string', 'max:255', 'regex:/^[\p{Arabic}A-Za-z0-9\s]+$/u'],
        'weight'=>['nullable', 'numeric'],
        'measurement_unit.desc_en'=>['required'],
        'selling_price'=>['required','numeric'],
        'hiddenItem'=>['nullable']
       ]);
       $item = new Item();
       $item->name= $request->name;
       $item->weight= $request->weight == null? null: $request->weight;
       $item->measurement_unit= $request->measurement_unit['desc_en'];
       $item->selling_price= $request->selling_price;
       $item->hidden = $request->hiddenItem;
       $item->save();
       return "item has been stored successfully";
    }

   
    public function showAll()
    {
        $items = QueryBuilder::for(Item::class)
            ->defaultSort('id')
            ->allowedSorts(['id', 'name','measurement_unit','selling_price'])
            ->allowedFilters([ 'name','measurement_unit','selling_price'])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();

        return Inertia::render('Items/Index', [
            'items' => $items
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
                key: "measurement_unit",
                label: __("Measurement Unit"),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "selling_price",
                label: __("Selling Price"),
                canBeHidden: true,
                hidden: false,
                sortable: true,
                searchable: true
            )->column(
                key: "hidden",
                label: __("Hidden"),
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  Item $item)
    {
        $data=$request->validate([
            'name'=>['required', 'string', 'max:255', 'regex:/^[\p{Arabic}A-Za-z0-9\s]+$/u'],
            'weight'=>['nullable', 'numeric'],
            'measurement_unit.desc_en'=>['required'],
            'selling_price'=>['required','numeric'],
            'hiddenItem'=>['nullable']
           ]);

        $item->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
    }
}
