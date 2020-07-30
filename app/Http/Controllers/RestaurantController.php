<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\Restaurant;
use App\Category;
use App\Comment;
use App\Workhour;
use App\Table;

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

        return view('pages.restaurant.index', ['categories' => null]);
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
        $restaurant = Restaurant::findOrFail($id);
        $workhours = $restaurant->getWorkhoursTable();
        $comments = $restaurant->comments()->orderBy('updated_at', 'desc')->paginate(10);

        return view('pages.restaurant.show', ['restaurant' => $restaurant, 'workhours' => $workhours, 'comments' => $comments]);
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

        $categories = Category::orderBy('name', 'asc')->get(); // All categories
        $rest_cats = $restaurant->getCategoriesNameTable(); // Our selected categories
        $workhours = $restaurant->getWorkhoursTable(); // Our workhours
        $tables = $restaurant->tables()->get(); // Our tables

        return view('pages.restaurant.edit', [
            'restaurant' => $restaurant,
            'categories' => $categories,
            'rest_cats' => $rest_cats,
            'workhours' => $workhours,
            'tables' => $tables,
        ]);
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
        //dd($request);

        $restaurant = Restaurant::findOrFail($id);

        $this->authorize('edit-restaurant', $restaurant); // $user is automatically passed

        // Validate
        $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
            'description' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string|regex:/(\+385)[ ][0-9]{2}[ ][0-9]{6}[0-9]?/',
            'website' => 'required|string|regex:"http[s]?://.*"',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB FILE SIZE LIMIT
            'delete_image' => 'nullable|boolean',

            'category' => 'required|array|min:3|max:3',
            'category.*' => 'nullable|string|distinct',

            'wh_start' => 'required|array|min:7|max:7',
            'wh_start.*' => 'nullable|string|date_format:H:i',
            'wh_end' => 'required|array|min:7|max:7',
            'wh_end.*' => 'nullable|string|date_format:H:i',

            't_id' => 'required|array|min:1',
            't_id.*' => 'nullable|numeric',
            't_seat'  => 'required|array|min:1',
            't_seat.*' => 'required|numeric|min:1|max:99',
            't_desc' => 'required|array|min:1',
            't_desc.*' => 'nullable|string',
        ]);

        // Categories
        $restaurant->categories()->detach(); // Remove all categories then re add them
        foreach (request('category') as $category) {
            if ($category) {
                $restaurant->categories()->attach(Category::where('name', $category)->first());
            }
        }

        // Workhours
        $restaurant->workhours()->delete(); // Remove all associated workhours then re add them
        for ($i = 0; $i < 7; $i++) {
            $start_time = request('wh_start.' . $i);
            $end_time = request('wh_end.' . $i);
            if ($start_time and $end_time) {
                $workhour = new Workhour();
                $workhour->day_of_week = $i;
                $workhour->open_time = $start_time;
                $workhour->close_time = $end_time;
                $workhour->restaurant()->associate($restaurant);
                $workhour->save();
            }
        }



        // Tables
        foreach ($restaurant->tables()->get() as $table) { // Delete the ones we are no longer using
            $isFound = false;

            for ($i=0; $i < count(request('t_id')); $i++) {
                $t_id = request('t_id.'.$i);
                if ($t_id == $table->id) {
                    $isFound = true;
                }
            }

            if ($isFound == false) {
                $table = Table::find($table->id);
                $table->deleted = true;
                $table->save();
            }
        }
        for ($i=0; $i < count(request('t_id')); $i++) { // Edit, Add the ones left
            $t_id = request('t_id.'.$i);
            if ($t_id) {
                $table = Table::find($t_id)->first();
                $table->seat_count = request('t_seat.'.$i);
                $table->description = request('t_desc.'.$i);
                $table->save();
            } else {
                $table = new Table();
                $table->seat_count = request('t_seat.'.$i);
                $table->description = request('t_desc.'.$i);
                $table->restaurant()->associate($restaurant);
                $table->save();
            }
        }

        // Restaurant
        $restaurant->name = request('name');
        $restaurant->description = request('description');
        $restaurant->address = request('address');
        $restaurant->phone = request('phone');
        $restaurant->website = request('website');
        $restaurant->address = request('address');

        // Restaurant picture
        if ($request->has('delete_image') || $request->hasFile('file')) {
            // Delete the old file
            if ($restaurant->image_path !== 'placeholder.png') {
                File::delete('storage/images/restaurant/' . $restaurant->image_path);
            }

            $request->has('delete_image') ? $restaurant->image_path = 'placeholder.png' : $restaurant->image_path = $this->uploadImage($request);
        }

        return redirect(route('restaurant.show', $id))->with('success', 'Restaurant edited');
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

    public function order($id)
    {
        if (!Auth::check()) {
            abort(403);
        }

        $restaurant = Restaurant::findOrFail($id);

        return view('pages.restaurant.order', ['restaurant' => $restaurant]);
    }

    public function favorite($id)
    {
        // We dont need to authorize, this will simply do nothing for the non-user and return him
        // to restaurant.show
        $restaurant = Restaurant::findOrFail($id);

        $user = auth()->user();

        if ($user) {
            $user->toggleFavorite($restaurant);
        }

        return redirect(route('restaurant.show', $id));
    }
}
