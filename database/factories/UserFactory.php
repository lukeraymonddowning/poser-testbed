<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->afterMaking(User::class, function($user, $faker) {
    $user->remember_token = "foobar";
});

$factory->afterCreating(User::class, function($user, $faker) {
    $user->groups()->saveMany(factory(\App\Group::class)->times(20)->make());
});

$factory->afterMakingState(User::class, 'unverified', function($user, $faker) {
    $user->remember_token = "makingStateFoobar";
});

$factory->afterCreatingState(User::class, 'unverified', function($user, $faker) {
    $user->groups()->saveMany(factory(\App\Group::class)->times(20)->make());
});

$factory->state(User::class, 'unverified', [
    'email_verified_at' => null
]);

$factory->state(User::class, 'johndoe', [
    'name' => "John Doe"
]);
