<?php

use Illuminate\Database\Seeder;

use App\Workhour;

class WorkhourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workhours = [
            ['day_of_week' => 0, 'open_time'  => '08:00:00', 'close_time' => '23:00:00', 'restaurant_id' => 1],
            ['day_of_week' => 1, 'open_time'  => '08:00:00', 'close_time' => '23:00:00', 'restaurant_id' => 1],
            ['day_of_week' => 2, 'open_time'  => '08:00:00', 'close_time' => '23:00:00', 'restaurant_id' => 1],
            ['day_of_week' => 3, 'open_time'  => '08:00:00', 'close_time' => '23:00:00', 'restaurant_id' => 1],
            ['day_of_week' => 4, 'open_time'  => '08:00:00', 'close_time' => '23:00:00', 'restaurant_id' => 1],
            ['day_of_week' => 5, 'open_time'  => '08:00:00', 'close_time' => '23:00:00', 'restaurant_id' => 1]
        ];

        foreach ($workhours as $workhour) {
            Workhour::create($workhour);
        }
    }
}
