<?php

namespace Tests\Feature\Poser;

use Tests\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FactoryStateTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function it_can_load_factory_states()
    {
        $user = UserFactory::new()
                           ->state('unverified')
                           ->withCustomers(30)();

        $this->assertNull($user->email_verified_at);
        $this->assertCount(30, $user->customers);
    }

    /** @test */
    public function it_can_load_factory_states_using_the_as_method()
    {
        $user = UserFactory::new()
                           ->as('unverified')
                           ->withCustomers(30)();

        $this->assertNull($user->email_verified_at);
        $this->assertCount(30, $user->customers);
    }

    /** @test */
    public function it_can_load_multiple_factory_states() {
        $users = UserFactory::times(15)
                           ->states('unverified', 'johndoe')
                           ->withCustomers(30)();

        $users->each(function($user) {
            $this->assertNull($user->email_verified_at);
            $this->assertEquals("John Doe", $user->name);
            $this->assertCount(30, $user->customers);
        });
    }
}
