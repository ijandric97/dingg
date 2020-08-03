<?php

namespace App\View\Components;

use App\Category;
use Illuminate\View\Component;
use Illuminate\View\View;

class CategoryCards extends Component
{
    /**
     * @var Category[] $categories;
     */
    public $categories;

    /**
     * Create a new component instance.
     *
     * @param Category[] $categories
     */
    public function __construct($categories)
    {
        $this->categories = $categories;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.category-cards');
    }
}
