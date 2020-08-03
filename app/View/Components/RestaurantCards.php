<?php

namespace App\View\Components;

use App\Restaurant;
use Illuminate\View\Component;
use Illuminate\View\View;

class RestaurantCards extends Component
{
    /**
     * @var Restaurant[] $restaurants
     */
    public $restaurants;

    /**
     * Create a new component instance.
     *
     * @param Restaurant[] $restaurants
     */
    public function __construct($restaurants)
    {
        $this->restaurants = $restaurants;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.restaurant-cards');
    }
}
