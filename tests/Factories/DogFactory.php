<?php

namespace Tests\Factories;

use Lukeraymonddowning\Poser\Factory;

/**
  * @method \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection|\App\Dog[]|\App\Dog __invoke($attributes = [])
  * @method \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection|\App\Dog[]|\App\Dog create($attributes = [])
  * @method \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection|\App\Dog[]|\App\Dog make($attributes = [])
  */
class DogFactory extends Factory
{

    public function defaultForOwner()
    {
        return UserFactory::new()->withAttributes(['name' => 'Doug Owner']);
    }

}
