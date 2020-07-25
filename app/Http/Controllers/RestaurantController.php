<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

use App\Restaurant;
use App\Category;

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
        return view('pages.restaurant.show', ['restaurant' => Restaurant::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $restaurant = Restaurant::findOrFail($id);

        $this->authorize('edit-restaurant', $restaurant); // $user is automatically passed

        //dd($restaurant->categories()->get());
        // Prepare categories
        $categories = Category::orderBy('name', 'asc')->get();

        // Prepare workhours
        $workhours = $restaurant->getWorkhoursTable();
        $rest_cats = $restaurant->getCategoriesNameTable(); // Our selected categories

        return view('pages.restaurant.edit', ['restaurant' => $restaurant, 'categories' => $categories, 'rest_cats' => $rest_cats, 'workhours' => $workhours]);
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

        $restaurant = Restaurant::findOrFail($id);

        $this->authorize('edit-restaurant', $restaurant); // $user is automatically passed

        // we should detach all categories, then attach the selected ones :)

        // Validate
        $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
            'description' => 'required|string',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB FILE SIZE LIMIT
        ]);
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
