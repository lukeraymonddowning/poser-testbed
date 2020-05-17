<?php

namespace Tests\Feature\Poser;

use App\User;
use Tests\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LaravelFactoryRelationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_the_expected_number_of_users() {
        $user = UserFactory::new()->withCustomers(10)();

        $this->assertCount(1, User::all());
    }
}
