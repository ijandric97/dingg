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
            ['name' => 'admin', 'email' => 'admin@dingg.com', 'password' => bcrypt('JaSamAdmin'), 'role' => 'admin', 'phone' => ''],
            ['name' => 'food_village', 'email' => 'info@food_village.com', 'password' => bcrypt('12345678'), 'role' => 'restaurant', 'phone' => '+385 51 330653'],
            ['name' => 'megic', 'email' => 'info@megich.com', 'password' => bcrypt('12345678'), 'role' => 'restaurant', 'phone' => '+385 51 648759'],
            ['name' => 'user1', 'email' => 'user1@test.com', 'password' => bcrypt('12345678'), 'role' => 'user', 'phone' => '+385 99 1234567'],
            ['name' => 'user2', 'email' => 'user2@test.com', 'password' => bcrypt('12345678'), 'role' => 'user', 'phone' => '+385 99 1234567'],
            ['name' => 'user3', 'email' => 'user3@test.com', 'password' => bcrypt('12345678'), 'role' => 'user', 'phone' => '+385 99 1234567'],
            ['name' => 'user4', 'email' => 'user4@test.com', 'password' => bcrypt('12345678'), 'role' => 'user', 'phone' => '+385 99 1234567'],
            ['name' => 'user5', 'email' => 'user5@test.com', 'password' => bcrypt('12345678'), 'role' => 'user', 'phone' => '+385 99 1234567']
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
