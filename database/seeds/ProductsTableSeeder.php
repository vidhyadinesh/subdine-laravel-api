<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\Product::class, 20)->create();
        Product::truncate();

	    $product = [
	        ['id' => '1', 'name' => 'Veg Biryani', 'reference' => 'VB', 'quantity' => 40, 'price' => 70],
	        ['id' => '2', 'name' => 'Chicken Biryani', 'reference' => 'CB', 'quantity' => 50, 'price' => 100], 
	        ['id' => '3', 'name' => 'Meal', 'reference' => 'ML', 'quantity' => 30, 'price' => 70], ['id' => '4', 'name' => 'Special Meal', 'reference' => 'SPML', 'quantity' => 60, 'price' => 100], ['id' => '5', 'name' => 'Tea', 'reference' => 'Tea', 'quantity' => 100, 'price' => 10]
	        	        
        ];

       Product::insert($product);
    }
}
