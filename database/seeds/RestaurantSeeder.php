<?php

use Illuminate\Database\Seeder;

use App\Restaurant;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create(); // FIXME: Remove this and get proper pictures :)

        //Restaurant::truncate();

        $restaurants = [
            [
                'name' => 'Food City Hamby', 'description' => 'We are your burger buddy', 'address' => 'Ante Starčevića 11a',
                'phone' => '+385 51 330653', 'website' => 'http://www.foodcity.hr/lokali.php#', 'owner_id' => 1, 'image_path' => 'american.jpg'
            ],
            [
                'name' => 'test', 'description' => 'test', 'address' => 'test',
                'phone' => '+385 51 330653', 'website' => 'http://www.example.com', 'owner_id' => 1, 'image_path' => 'placeholder.png'
            ],
        ];

        foreach ($restaurants as $restaurant) {
            Restaurant::create($restaurant);
        }
    }
}
