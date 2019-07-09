<?php

use Maxcelos\Financial\Entities\Category;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'color' => $faker->hexColor,
        'type'  => $faker->randomElement(['debit', 'credit'])
    ];
});
