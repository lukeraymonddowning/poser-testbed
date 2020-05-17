<?php

namespace Tests\Factories;

use Lukeraymonddowning\Poser\Factory;

/**
  * @method \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection|\App\Customer[]|\App\Customer create($attributes = [])
  * @method \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection|\App\Customer[]|\App\Customer make($attributes = [])
  */
class CustomerFactory extends Factory {

    public function defaultForUser()
    {
        return UserFactory::new()->withAttributes(['name' => "John Doe"]);
    }

}
