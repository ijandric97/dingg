<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CategoryCards extends Component
{
    /**
     * The categories type.
     * @var Category[] $categories
     */
    public $categories;

    /**
     * Create a new component instance.
     * @param Category[] $categories
     * @return void
     */
    public function __construct($categories)
    {
        $this->categories = $categories;
    }

    /**
     * Get the view / contents that represent the component.
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.category-cards');
    }
}
