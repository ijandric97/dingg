<?php

namespace App\Http\Controllers;

use App\Category;
use App\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // ! HACK: We do not want middleware to protect our homecontroller
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return View
     */
    public function index()
    {
        $favorites = [];
        $recommended = collect(new Restaurant());;
        $user = Auth::user();

        if ($user) {
            $favorites =  $user->favorites()->inRandomOrder()->limit(3)->get();

            $lastOrder =  $user->orders()->with('restaurant')->orderBy('id', 'desc')->first();
            if ($lastOrder) {
                $recommended = $lastOrder->restaurant
                    ->categories()->inRandomOrder()->limit(1)->first()
                    ->restaurants()->inRandomOrder()->limit(3)->get();
            }
        }

        return view('pages.home', [
            'categories' => Category::inRandomOrder()->limit(3)->get(),
            'restaurants' => Restaurant::inRandomOrder()->limit(3)->get(),
            'favorites' => $favorites,
            'recommended' => $recommended,
        ]);
    }

    /**
     * Show the application search.
     *
     * @return View
     */
    public function search()
    {
        // Search if get contains ?name field
        $name = request()->input('name');
        if ($name) {
            $restaurants = Restaurant::where('name', 'LIKE', '%' . $name . '%') // Name
                ->orWhere('description', 'LIKE',  '%' . $name . '%') // Description
                ->orWhereHas('categories', function($query) use ($name) { // Category Name
                    $query->where('categories.name', 'LIKE', '%' . $name . '%');
                })
                ->paginate(30); // Return max 30 restaurants
        } else {
            // Return all restaurants if we are stupid enough to not search for anything
            $restaurants = Restaurant::orderBy('name', 'asc')->paginate(50);
        }

        return view('pages.search', [
            'restaurants' => $restaurants,
            'query' => $name
        ]);
    }
}
