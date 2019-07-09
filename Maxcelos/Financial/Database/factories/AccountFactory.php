<?php

use Faker\Generator as Faker;
use Maxcelos\Financial\Entities\Account;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Account::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'amount' => $faker->numberBetween()
    ];
});
