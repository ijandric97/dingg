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
            [
                'name' => 'food_city_hamburger', 'email' => 'food_city_hamburger@test.com', 'password' => bcrypt('12345678'),
                'role' => 'restaurant', 'phone' => '+38551330653', 'image_path' => 'placeholder.jpg'
            ],
            [
                'name' => 'test_admin', 'email' => 'test_admin@test.com', 'password' => bcrypt('12345678'),
                'role' => 'admin', 'phone' => '+38551330653', 'image_path' => 'placeholder.jpg'
            ],
            [
                'name' => 'jandra_1', 'email' => 'jandra_1@test.com', 'password' => bcrypt('12345678'),
                'role' => 'user', 'phone' => '+38551330653', 'image_path' => 'placeholder.jpg'
            ],
            [
                'name' => 'jandra_2', 'email' => 'jandra_2@test.com', 'password' => bcrypt('12345678'),
                'role' => 'user', 'phone' => '+38551330653', 'image_path' => 'placeholder.jpg'
            ],
            [
                'name' => 'jandra_3', 'email' => 'jandra_3@test.com', 'password' => bcrypt('12345678'),
                'role' => 'user', 'phone' => '+38551330653', 'image_path' => 'placeholder.jpg'
            ],
            [
                'name' => 'jandra_4', 'email' => 'jandra_4@test.com', 'password' => bcrypt('12345678'),
                'role' => 'user', 'phone' => '+38551330653', 'image_path' => 'placeholder.jpg'
            ],
            [
                'name' => 'jandra_5', 'email' => 'jandra_5@test.com', 'password' => bcrypt('12345678'),
                'role' => 'user', 'phone' => '+38551330653', 'image_path' => 'placeholder.jpg'
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
