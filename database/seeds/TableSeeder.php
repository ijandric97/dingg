<?php

use Illuminate\Database\Seeder;

use App\Table;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = [
            ['seat_count' => 4,	'restaurant_id' => '1'],
            ['seat_count' => 4,	'restaurant_id' => '1'],
            ['seat_count' => 4,	'restaurant_id' => '1'],
            ['seat_count' => 4,	'restaurant_id' => '1'],
            ['seat_count' => 4,	'restaurant_id' => '1'],
            ['seat_count' => 4,	'restaurant_id' => '1'],
            ['seat_count' => 4,	'restaurant_id' => '1'],
            ['seat_count' => 4,	'restaurant_id' => '1'],
            ['seat_count' => 4,	'restaurant_id' => '1'],
            ['seat_count' => 4,	'restaurant_id' => '1'],
        ];

        foreach ($tables as $table) {
            Table::create($table);
        }
    }
}
