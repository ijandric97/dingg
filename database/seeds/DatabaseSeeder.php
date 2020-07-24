<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Add all seeders here or else you will have to run them manually by one
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            RestaurantSeeder::class,
            WorkhourSeeder::class,
            TableSeeder::class,
            CommentSeeder::class,
            GroupSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class
        ]);

        // TODO: DO Many to many associations here or something :)
        $user = App\User::find(1);
        $restaurant = App\Restaurant::find(1);
        $restaurant->owner()->associate($user);

        $category = App\Category::find(1);
        $restaurant = App\Restaurant::find(1);
        $restaurant->categories()->attach($category);

        $workhour = App\Workhour::find(1);
        $restaurant = App\Restaurant::find(1);
        $workhour->restaurant()->associate($workhour);

        //dd($user->ownedRestaurants());
        //$user->ownedRestaurants()->add($restaurant); dpes not work
    }
}
