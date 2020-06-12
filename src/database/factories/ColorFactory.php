<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Color;
use App\Constants\Color as Constant;
use Faker\Generator as Faker;

$factory->define(Color::class, function (Faker $faker) {
    return [
        Constant::NAME => $faker->safeColorName,
        Constant::HEX => $faker->hexcolor
    ];
});
