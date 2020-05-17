<?php

namespace Tests\Feature\Poser;

use Tests\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StateMethodsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_use_the_as_prefix_to_build_out_states() {
        $user = UserFactory::asUnverified()->asJohndoe()();

        $this->assertNull($user->email_verified_at);
        $this->assertEquals('John Doe', $user->name);
    }
}
