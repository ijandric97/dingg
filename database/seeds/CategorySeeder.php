<?php

use Illuminate\Database\Seeder;

use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate(); // Remove duplicates

        // The images will have to be copied into resources/images/category/ folder :)
        $categories =  [
            ['name' => 'American', 'description' => 'The freshest fish on dry land.', 'image_path' => 'american.jpg'],
            ['name' => 'Asian', 'description' => 'The freshest fish on dry land.', 'image_path' => 'asian.jpg'],
            ['name' => 'Bakery', 'description' => 'The freshest fish on dry land.', 'image_path' => 'bakery.jpg'],
            ['name' => 'BBQ', 'description' => 'The freshest fish on dry land.', 'image_path' => 'bbq.jpg'],
            ['name' => 'Breakfast', 'description' => 'The freshest fish on dry land.', 'image_path' => 'breakfast.jpg'],
            ['name' => 'Burger', 'description' => 'The freshest fish on dry land.', 'image_path' => 'burger.jpg'],
            ['name' => 'Chinese', 'description' => 'The freshest fish on dry land.', 'image_path' => 'chinese.jpg'],
            ['name' => 'Dessert', 'description' => 'The freshest fish on dry land.', 'image_path' => 'dessert.jpg'],
            ['name' => 'Fish', 'description' => 'The freshest fish on dry land.', 'image_path' => 'fish.jpg'],
            ['name' => 'Grocery', 'description' => 'The freshest fish on dry land.', 'image_path' => 'grocery.jpg'],
            ['name' => 'Healthy', 'description' => 'The freshest fish on dry land.', 'image_path' => 'healthy.jpg'],
            ['name' => 'Italian', 'description' => 'The freshest fish on dry land.', 'image_path' => 'italian.jpg'],
            ['name' => 'Kebab', 'description' => 'The freshest fish on dry land.', 'image_path' => 'kebab.jpg'],
            ['name' => 'Mediterranean', 'description' => 'The freshest fish on dry land.', 'image_path' => 'mediterranean.jpg'],
            ['name' => 'Mexican', 'description' => 'The freshest fish on dry land.', 'image_path' => 'mexican.jpg'],
            ['name' => 'Noodles', 'description' => 'The freshest fish on dry land.', 'image_path' => 'noodles.jpg'],
            ['name' => 'Pasta', 'description' => 'The freshest fish on dry land.', 'image_path' => 'pasta.jpg'],
            ['name' => 'Pizza', 'description' => 'The freshest fish on dry land.', 'image_path' => 'pizza.jpg'],
            ['name' => 'Salad', 'description' => 'The freshest fish on dry land.', 'image_path' => 'salad.jpg'],
            ['name' => 'Sandwich', 'description' => 'The freshest fish on dry land.', 'image_path' => 'sandwich.jpg'],
            ['name' => 'Smoothie', 'description' => 'The freshest fish on dry land.', 'image_path' => 'smoothie.jpg'],
            ['name' => 'Steak', 'description' => 'The freshest fish on dry land.', 'image_path' => 'steak.jpg'],
            ['name' => 'Street Food', 'description' => 'The freshest fish on dry land.', 'image_path' => 'street_food.jpg'],
            ['name' => 'Sushi', 'description' => 'The freshest fish on dry land.', 'image_path' => 'sushi.jpg'],
            ['name' => 'Turkish', 'description' => 'The freshest fish on dry land.', 'image_path' => 'turkish.jpg'],
            ['name' => 'Vegan', 'description' => 'The freshest fish on dry land.', 'image_path' => 'vegan.jpg'],
            ['name' => 'Wings', 'description' => 'The freshest fish on dry land.', 'image_path' => 'wings.jpg'],
        ];

        //DB::table('categories')->truncate();

        foreach ($categories as $category) {
            Category::create($category);
        }
        
        // foreach... Category::create fails because create is Eloquent function that always expects a timestamp?
        // to fix this either put $timestamps = false; into the Category Model or do func specified below.
        // Category::insert($categories); //This works faster but is not Eloquent friendly
    }
}
