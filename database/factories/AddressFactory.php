<?php

/** @var Factory $factory */

use App\User;
use App\Address;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'line_1' => $faker->address,
//        'user_id' => function() {
//            return factory(User::class)->create()->id;
//        }
    ];
});
