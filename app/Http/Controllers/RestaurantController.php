<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\Restaurant;
use App\Category;
use App\Comment;
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
     * @param  Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show(Restaurant $restaurant)
    {
        return view('pages.restaurant.show', [
            'restaurant' => $restaurant,
            'workhours' => $restaurant->getWorkhoursTable(),
            'comments' => $restaurant->comments()->orderBy('updated_at', 'desc')->paginate(5),
            'rating' => $restaurant->rating(),
            'categories' => $restaurant->categories()->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function edit(Restaurant $restaurant)
    {
        $this->authorize('edit-restaurant', $restaurant); // $user is automatically passed

        $categories = Category::orderBy('name', 'asc')->get(); // All categories
        $rest_cats = $restaurant->getCategoriesNameTable(); // Our selected categories

        return view('pages.restaurant.edit', [
            'restaurant' => $restaurant,
            'categories' => $categories,
            'rest_cats' => $rest_cats,
            'tables' => $restaurant->tables()->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
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
        ]);

        // Categories
        $restaurant->categories()->detach(); // Remove all categories then re add them
        foreach (request('category') as $category) {
            if ($category) {
                $restaurant->categories()->attach(Category::where('name', $category)->first());
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

        $restaurant->save();

        return redirect(route('restaurant.show', $restaurant))->with('success', 'Restaurant edited');
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

    /**
     * Undocumented function
     *
     * @param \Illuminate\Http\Request  $request
     * @return string
     */
    private function uploadImage($request)
    {
        // Create new Filename to store
        $filenameWithExt = $request->file('file')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('file')->getClientOriginalExtension();
        $filenameToStore = $filename . '_' . time() . '.' . $extension;

        // Resize and store the new file
        $image_resize = Image::make($request->file('file')->getRealPath());
        $image_resize->resize(320, 240);
        $image_resize->save('storage/images/restaurant/' . $filenameToStore);

        return $filenameToStore;
    }
}
