<?php

namespace Tests\Feature;

use App\User;
use Tests\Factories\DogFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_generate_a_default_owner() {
        $dog = DogFactory::new()();

        $this->assertInstanceOf(User::class, $dog->owner);
        $this->assertEquals('Doug Owner', $dog->owner->name);
    }
}
