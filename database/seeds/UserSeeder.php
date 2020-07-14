<?php

use Illuminate\Database\Seeder;

use App\User;

class UserSeeder extends Seeder
{

    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create(); // FIXME: Remove this and get proper pictures :)

        //User::truncate();

        $users = [
            ['name' => 'food_city_hamburger', 'email' => 'food_city_hamburger@test.com', 'password' => bcrypt('12345678'),
                'role' => 'restaurant', 'phone' => '+38551330653', 'image_path' => $faker->image(storage_path('app\public\images'), 256, 256, null, false)],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
