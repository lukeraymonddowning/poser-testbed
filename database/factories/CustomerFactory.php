<?php

/** @var Factory $factory */

use App\User;
use App\Customer;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
//        'user_id' => function() {
//            return factory(User::class)->create()->id;
//        }
    ];
});
