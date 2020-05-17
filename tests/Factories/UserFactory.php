<?php

namespace Tests\Factories;

use Lukeraymonddowning\Poser\Factory;

/**
 * @method \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection|\App\User[]|\App\User
 *         create($attributes = [])
 * @method \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection|\App\User[]|\App\User
 *         make($attributes = [])
 */
class UserFactory extends Factory
{

    public function defaultWithAddress() {
        return AddressFactory::new();
    }

    public function defaultWithCustomers()
    {
        return \factory(\App\Customer::class)->times(30)->make();
    }

}
