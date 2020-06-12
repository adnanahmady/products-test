<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductType;
use App\Constants\ProductType as Constant;
use Faker\Generator as Faker;
use App\Product;
use App\Color;

$factory->define(ProductType::class, function (Faker $faker) {
    return [
        Constant::PRICE => $faker->numberBetween(1000, 9999999),
        Constant::PRODUCT_ID => factory(Product::class)->create()->id,
        Constant::COLOR_ID => factory(Color::class)->create()->id
    ];
});
