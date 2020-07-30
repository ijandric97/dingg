<?php

namespace App\Http\Controllers;

use App\Table;
use App\Restaurant;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Restaurant $restaurant)
    {
        $this->authorize('edit-restaurant', $restaurant);

        return view('pages.restaurant.table.index', [
            'restaurant' => $restaurant,
            'tables' => $restaurant->tables()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Restaurant $restaurant)
    {
        $this->authorize('edit-restaurant', $restaurant);

        // Validate
        $request->validate([
            'id' => 'required|array|min:1',
            'id.*' => 'nullable|numeric',
            'seat_count'  => 'required|array|min:1',
            'seat_count.*' => 'required|numeric|min:1|max:99',
            'description' => 'required|array|min:1',
            'description.*' => 'nullable|string',
        ]);

        // Delete non-existing ones by comparing ids in the request with the id's in the base
        foreach ($restaurant->tables()->get() as $table) {
            $found = false;

            for ($i = 0; $i < count(request('id')); $i++) {
                $id = request('id.' . $i);
                if ($id == $table->id) {
                    $found = true;
                }
            }

            if ($found == false) {
                $table->deleted = true;
                $table->save();
            }
        }

        // Create / Edit the rest
        for ($i = 0; $i < count(request('id')); $i++) {
            $id = request('id.' . $i);

            if ($id) {
                $table = Table::find($id)->first();
            } else {
                $table = new Table();
            }

            $table->seat_count = request('seat_count.' . $i);
            $table->description = request('description.' . $i);
            $table->restaurant()->associate($restaurant);
            $table->save();
        }

        return redirect(route('restaurant.show', $restaurant->id))->with('success', 'Tables edited');
    }
}
