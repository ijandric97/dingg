<?php

namespace App\Http\Controllers;

use App\Workhour;
use App\Restaurant;
use Illuminate\Http\Request;

class WorkhourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Restaurant $restaurant)
    {
        $this->authorize('edit-restaurant', $restaurant);

        return view('pages.restaurant.workhour.index', [
            'restaurant' => $restaurant,
            'workhours' => $restaurant->getWorkhoursTable(),
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
            'open_time' => 'required|array|min:7|max:7',
            'open_time.*' => 'nullable|string|date_format:H:i',
            'close_time' => 'required|array|min:7|max:7',
            'close_time.*' => 'nullable|string|date_format:H:i',
        ]);

        // Workhours
        $restaurant->workhours()->delete(); // Remove all associated workhours then re add them
        for ($i = 0; $i < 7; $i++) {
            $start_time = request('open_time.' . $i);
            $close_time = request('close_time.' . $i);

            if ($start_time and $close_time) {
                $workhour = new Workhour();
                $workhour->day_of_week = $i;
                $workhour->open_time = $start_time;
                $workhour->close_time = $close_time;
                $workhour->restaurant()->associate($restaurant);
                $workhour->save();
            }
        }

        return redirect(route('restaurant.show', $restaurant->id))->with('success', 'Workhours edited');
    }
}
