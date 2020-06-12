<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\ProductConstant;
use App\Color;
use App\Constants\ColorProduct;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $prices = [10000, 17000, 25000, 18000];
        $product = factory(Product::class)->create();
        $products = factory(Product::class, 25)->create();
        
        $products->each(function ($product) {
            for($i = 0; $i < 2; $i++) {
                $product->colors()->attach(
                    factory(Color::class)->create()->id,
                    [ColorProduct::PRICE => round(rand(1000, 999999), -3)]
                );
            }
        });

        array_map(function ($price) use ($product) {
            $product->colors()->attach(
                factory(Color::class)->create()->id,
                [ColorProduct::PRICE => $price]
            );
        }, $prices);
    }
}
