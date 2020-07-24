<?php

namespace App\Http\Controllers;

use App\Category;
use App\Restaurant;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // HACK: We do not want middleware to protect our homecontroller
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            'categories' => Category::inRandomOrder()->limit(3)->get(),
            'restaurants' => Restaurant::inRandomOrder()->limit(3)->get()
        ]);
    }
}
