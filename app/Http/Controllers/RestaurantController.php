<?php

namespace App\Http\Controllers;

use App\Restaurant;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$categories = Category::all();
        foreach ($categories as $category) {
            # TODO -> some kind of join on restaurants to get how many restaurants ar ein category just like in wolt...
        }*/

        return view('restaurant.index', ['categories' => null]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $restaurant = Restaurant::find($id);

        $this->authorize('edit-restaurant', $restaurant);

        $workhours_temp = $restaurant->workhours()->orderBy('day_of_week', 'asc')->get();

        $workhours = [
            ['open_time' => '', 'close_time' => ''],
            ['open_time' => '', 'close_time' => ''],
            ['open_time' => '', 'close_time' => ''],
            ['open_time' => '', 'close_time' => ''],
            ['open_time' => '', 'close_time' => ''],
            ['open_time' => '', 'close_time' => ''],
            ['open_time' => '', 'close_time' => ''],
        ];

        foreach ($workhours_temp as $wh_tmp) {
            $workhours[$wh_tmp->day_of_week] = ['open_time' => $wh_tmp->open_time, 'close_time' => $wh_tmp->close_time];
        }

        return view('pages.restaurant.edit', ['restaurant' => $restaurant, 'workhours' => $workhours]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
