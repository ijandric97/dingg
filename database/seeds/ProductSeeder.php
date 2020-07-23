<?php

use Illuminate\Database\Seeder;

use App\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            ['name' => 'Hamby double burger', 'description' => 'Pecivo, 2x pljeskavica, zelena salata, umak aurora, kiseli krastavci, rajčica', 'image_path' => 'placeholder.png', 'price' => 35, 'discount' => 10, 'available' => true, 'group_id' => 1],
            ['name' => 'American burger', 'description' => 'Pecivo sa sezamom, XXL pljeskavica, senf, ketchup, salata, kiseli krastavci, sir, panceta', 'image_path' => 'placeholder.png', 'price' => 33, 'discount' => 0, 'available' => true, 'group_id' => 1],
            ['name' => 'Extra burger', 'description' => 'Lepinja, pljeskavica, luk, kupus, zelena salata, ajvar', 'image_path' => 'placeholder.png', 'price' => 25, 'discount' => 0, 'available' => true, 'group_id' => 1],
            ['name' => 'Texas grill burger', 'description' => 'Pecivo, pikantna pljeskavica, zelena salata, umak BBQ, prženi luk, rajčica', 'image_path' => 'placeholder.png', 'price' => 22, 'discount' => 0, 'available' => true, 'group_id' => 1],
            ['name' => 'Turkey burger', 'description' => 'Pecivo, pureći file, zelena salata, umak aurora, kiseli krastavci, rajčica', 'image_path' => 'placeholder.png', 'price' => 22, 'discount' => 0, 'available' => true, 'group_id' => 1],
            ['name' => 'Cheeseburger', 'description' => 'Pecivo, meso, sir, zelena salata, umak aurora, kiseli krastavci', 'image_path' => 'placeholder.png', 'price' => 21, 'discount' => 0, 'available' => true, 'group_id' => 1],
            ['name' => 'Chickenburger', 'description' => 'Pecivo, umak aurora, piletina, zelena salata, kiseli krastavci', 'image_path' => 'placeholder.png', 'price' => 21, 'discount' => 0, 'available' => true, 'group_id' => 1],
            ['name' => 'Hamby burger', 'description' => 'Pecivo, pljeskavica, zelena salata, umak aurora, kiseli krastavci, rajčica', 'image_path' => 'placeholder.png', 'price' => 21, 'discount' => 0, 'available' => true, 'group_id' => 1],
            ['name' => 'Fish burger', 'description' => 'Pecivo, riba, zelena salata, umak aurora, kiseli krastavci', 'image_path' => 'placeholder.png', 'price' => 20, 'discount' => 0, 'available' => true, 'group_id' => 1],
            ['name' => 'Hamburger', 'description' => 'Pecivo, meso, zelena salata, umak aurora, kiseli krastavci', 'image_path' => 'placeholder.png', 'price' => 20, 'discount' => 0, 'available' => true, 'group_id' => 1],
            ['name' => 'Soja burger', 'description' => 'Pecivo, soja burger, zelena salata, umak aurora, kiseli krastavci', 'image_path' => 'placeholder.png', 'price' => 20, 'discount' => 0, 'available' => true, 'group_id' => 1],
            ['name' => 'Vegeburger', 'description' => 'Pecivo, pohani sir, umak aurora, zelena salata, kiseli krastavci', 'image_path' => 'placeholder.png', 'price' => 19, 'discount' => 0, 'available' => true, 'group_id' => 1],

            ['name' => 'Tortilla tuna', 'description' => '', 'image_path' => 'placeholder.png', 'price' => 28, 'discount' => 0, 'available' => true, 'group_id' => 2],
            ['name' => 'Tortilla vege', 'description' => '', 'image_path' => 'placeholder.png', 'price' => 28, 'discount' => 0, 'available' => true, 'group_id' => 2],
            ['name' => 'Tortilla mexicana', 'description' => '', 'image_path' => 'placeholder.png', 'price' => 28, 'discount' => 0, 'available' => true, 'group_id' => 2],
            ['name' => 'Tortilla BBQ', 'description' => '', 'image_path' => 'placeholder.png', 'price' => 28, 'discount' => 0, 'available' => true, 'group_id' => 2],

            ['name' => 'Piletina žar sendvič', 'description' => 'Focaccia, piletina žar, umak mediteran, sir, svježa paprika', 'image_path' => 'placeholder.png', 'price' => 20, 'discount' => 0, 'available' => true, 'group_id' => 3],
            ['name' => 'Piletina tikvice sendvič', 'description' => 'Integralno pecivo, piletina žar, francuski umak, pohane tikvice', 'image_path' => 'placeholder.png', 'price' => 20, 'discount' => 0, 'available' => true, 'group_id' => 3],
            ['name' => 'Maxi pršut sendvič', 'description' => 'Maxi pecivo, pršut, sir, umak dalmatinski', 'image_path' => 'placeholder.png', 'price' => 20, 'discount' => 0, 'available' => true, 'group_id' => 3],
            ['name' => 'Pršut sir sendvič', 'description' => 'Ciabatta, pršut, sir', 'image_path' => 'placeholder.png', 'price' => 18, 'discount' => 0, 'available' => true, 'group_id' => 3],
            ['name' => 'Maxi aurora sendvič', 'description' => 'Maxi pecivo, šunka, sir, umak aurora', 'image_path' => 'placeholder.png', 'price' => 18, 'discount' => 0, 'available' => true, 'group_id' => 3],
            ['name' => 'Tuna sendvič', 'description' => 'Focaccia s maslinama, namaz od tune, zelena salata, svježa paprika', 'image_path' => 'placeholder.png', 'price' => 18, 'discount' => 0, 'available' => true, 'group_id' => 3],
            ['name' => 'Pohani sir sendvič', 'description' => 'Pecivo sa sezamom, umak tartar, pohani sir', 'image_path' => 'placeholder.png', 'price' => 17, 'discount' => 0, 'available' => true, 'group_id' => 3],

            ['name' => 'Sicilijanski umak', 'description' => '', 'image_path' => 'placeholder.png', 'price' => 3, 'discount' => 0, 'available' => true, 'group_id' => 4],
            ['name' => 'Grčki umak', 'description' => '', 'image_path' => 'placeholder.png', 'price' => 3, 'discount' => 0, 'available' => true, 'group_id' => 4],
            ['name' => 'Aurora umak', 'description' => '', 'image_path' => 'placeholder.png', 'price' => 3, 'discount' => 0, 'available' => true, 'group_id' => 4],
            ['name' => 'Tartar umak', 'description' => '', 'image_path' => 'placeholder.png', 'price' => 3, 'discount' => 0, 'available' => true, 'group_id' => 4],
            ['name' => 'Meksički umak', 'description' => '', 'image_path' => 'placeholder.png', 'price' => 3, 'discount' => 0, 'available' => true, 'group_id' => 4],

            ['name' => 'Pivo limenka 0,5', 'description' => '', 'image_path' => 'placeholder.png', 'price' => 17, 'discount' => 0, 'available' => true, 'group_id' => 5],
            ['name' => 'Coca-cola 0,5 l', 'description' => '', 'image_path' => 'placeholder.png', 'price' => 15, 'discount' => 0, 'available' => true, 'group_id' => 5],
            ['name' => 'Negazirana voda 0,5 l', 'description' => '', 'image_path' => 'placeholder.png', 'price' => 10, 'discount' => 0, 'available' => true, 'group_id' => 5],

            ['name' => 'Ožujsko 0,5 l', 'description' => '', 'image_path' => 'placeholder.png', 'price' => 17, 'discount' => 0, 'available' => true, 'group_id' => 6]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
