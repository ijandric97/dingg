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
            CategorySeeder::class
        ]);
    }
}
