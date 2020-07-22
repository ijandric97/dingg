<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CategoryCardsItem extends Component
{
    /**
     * The category type.
     * @var Category category
     */
    public $category;

    /**
     * Create a new component instance.
     * @param Category $category
     * @return void
     */
    public function __construct($category)
    {
        $this->category = $category;
    }

    /**
     * Get the view / contents that represent the component.
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.category-cards-item');
    }
}
