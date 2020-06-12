<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use App\User;
use Faker\Generator as Faker;
use App\Constants\Product as Constant;

$factory->define(Product::class, function (Faker $faker) {
    return [
        Constant::NAME => $faker->name,
        Constant::DESCRIPTION => $faker->text,
        Constant::USER_ID => factory(User::class)->create()->id
    ];
});
