<?php

namespace App\Http\Controllers;

use App\Category;
use App\Restaurant;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;


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
     * @return Renderable
     */
    public function index()
    {
        $favorites = null;
        if (Auth::user()) {
            $favorites =  Auth::user()->favorites()->inRandomOrder()->limit(3)->get();
        }

        return view('home', [
            'categories' => Category::inRandomOrder()->limit(3)->get(),
            'restaurants' => Restaurant::inRandomOrder()->limit(3)->get(),
            'favorites' => $favorites,
        ]);
    }
}
