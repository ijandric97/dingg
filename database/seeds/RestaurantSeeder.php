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
                'name' => 'Food Village Centar', 'description' => 'We are your burger buddy', 'address' => 'Ante Star 1',
                'phone' => '+385 51 311653', 'website' => 'http://www.foodvillage.hr/lokali.php#', 'owner_id' => 2, 'image_path' => 'american.jpg',
                'deleted' => false
            ],
            [
                'name' => 'Megić', 'description' => 'Volin megić!', 'address' => 'Centar 1',
                'phone' => '+385 51 648759', 'website' => 'http://www.megich.hr', 'owner_id' => 1, 'image_path' => 'placeholder.png',
                'deleted' => true
            ],
        ];

        foreach ($restaurants as $restaurant) {
            Restaurant::create($restaurant);
        }
    }
}
