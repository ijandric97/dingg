<?php

use Illuminate\Database\Seeder;

use App\Group;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            ['name' => 'Burgers', 'description' => 'Finest american burgers.', 'sort_order' => 0, 'restaurant_id' => 1],
            ['name' => 'Sandwiches', 'description' => 'Just like your mama used to make them.', 'sort_order' => 1, 'restaurant_id' => 1],
            ['name' => 'Tortilas', 'description' => 'Hot n spicy', 'sort_order' => 2, 'restaurant_id' => 1],
            ['name' => 'Sauces', 'description' => 'For the extra flavour!', 'sort_order' => 3, 'restaurant_id' => 1],
            ['name' => 'Drinks', 'description' => 'Freshen up!', 'sort_order' => 4, 'restaurant_id' => 1],
            ['name' => 'Beer', 'description' => 'Ideal partner for your burger.', 'sort_order' => 5, 'restaurant_id' => 1]
        ];

        foreach ($groups as $group) {
            Group::create($group);
        }
    }
}
