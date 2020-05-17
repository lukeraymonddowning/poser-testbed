<?php

/** @var Factory $factory */

use App\Customer;
use App\Models\Book;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'name' => $faker->words(5, true),
//        'customer_id' => function() {
//            return factory(Customer::class)->create()->id;
//        }
    ];
});
