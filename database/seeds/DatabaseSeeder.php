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
            RestaurantSeeder::class
        ]);

        $user = App\User::find(1);
        $restaurant = App\Restaurant::find(1);
        $restaurant->owner()->associate($user);

        dd($user->ownedRestaurants());
        //$user->ownedRestaurants()->add($restaurant); dpes not work
    }
}
