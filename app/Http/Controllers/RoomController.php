<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = QueryBuilder::for (Room::class)
            ->with('clinic')
            ->defaultSort('id')
            ->allowedSorts(['id', 'name'])
            ->allowedFilters(['name'])
            ->paginate(Request()->input('perPage', 20))
            ->withQueryString();

        return Inertia::render('Rooms/Index', [
            'rooms' => $rooms
        ])->table(function (InertiaTable $table) {
            $table->column(
                key:"id",
                label:"ID",
                canBeHidden:false,
                hidden:false,
                sortable:true
            )->column(
                key:"name",
                label:"Type",
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"branch",
                label:"Branch",
                canBeHidden:true,
                hidden:false,
                sortable:true,
                searchable:true
            )->column(
                key:"actions",
                label:"Actions"
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
            'name' => ['required','string','max:255'],
            'clinic_id' => ['required'],
        ]);

        $room = new Room();
        $room->name = $request->name;
        $room->clinic_id = $request->clinic_id;
        $room->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'clinic_id' => ['required'],
        ]);

        $room->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();
    }

    public function all(){
        // return Room::with('clinic')->get();
        return Room::all();
    }
}