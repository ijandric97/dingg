<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\Restaurant;
use App\Category;
use App\User;
use App\Helpers\AppHelper;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('pages.restaurant.index', [
            'restaurants' => Restaurant::paginate(30)]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('is-admin');

        return view('pages.restaurant.create', [
            'categories' => Category::orderBy('name', 'asc')->get(),
            'users' => User::pluck('name'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector|View
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('is-admin');

        // Validate
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string|regex:/(\+385)[ ][0-9]{2}[ ][0-9]{6}[0-9]?/',
            'website' => 'required|string|regex:"http[s]?://.*"',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB FILE SIZE LIMIT

            'owner' => 'required|string|exists:users,name',

            'category' => 'required|array|min:3|max:3',
            'category.*' => 'nullable|string|distinct',
        ]);

        $restaurant = new Restaurant([
            'name' => request('name'),
            'description' => request('description'),
            'address' => request('address'),
            'phone' => request('phone'),
            'website' => request('website'),
        ]);

        // Categories
        foreach (request('category') as $category) {
            if ($category) {
                $restaurant->categories()->attach(Category::where('name', $category)->first());
            }
        }

        // Restaurant picture
        $restaurant->image_path = 'placeholder.png';
        if ($request->hasFile('file')) {
            // Upload the image to database and update the image_path in the database
            $restaurant->image_path = AppHelper::uploadImage($request);
        }

        // OWNER
        // ! HACK: For some reason I cannot get the associate() to work?
        $restaurant->owner_id = User::where('name', request('owner'))->first()->id;

        $restaurant->save();

        return redirect(route('restaurant.show', $restaurant))->with('success', 'Restaurant created');
    }

    /**
     * Display the specified resource.
     *
     * @param Restaurant $restaurant
     * @return Application|Factory|Response|View
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
     * @param Restaurant $restaurant
     * @return View
     * @throws AuthorizationException
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
            'users' => User::pluck('name'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Restaurant $restaurant
     * @return Application|RedirectResponse|Response|Redirector
     * @throws AuthorizationException
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

            'owner' => 'nullable|string|exists:users,name',

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
                File::delete('storage/images/' . $restaurant->image_path);
            }

            $request->has('delete_image') ? $restaurant->image_path = 'placeholder.png' : $restaurant->image_path = AppHelper::uploadImage($request);
        }

        // OWNER
        if (request('owner') && Auth::user()->can('is-admin')) {
            // OWNER
            // ! HACK: For some reason I cannot get the associate() to work?
            $restaurant->owner_id = User::where('name', request('owner'))->first()->id;
        }

        $restaurant->save();

        return redirect(route('restaurant.show', $restaurant))->with('success', 'Restaurant edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Restaurant $restaurant
     * @return Application|RedirectResponse|Response|Redirector
     * @throws AuthorizationException
     */
    public function destroy(Restaurant $restaurant)
    {
        $this->authorize('is-admin');

        $restaurant->deleted = true;
        $restaurant->save();

        return redirect(route('restaurant.index'))->with('success', 'Restaurant Deleted');
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
