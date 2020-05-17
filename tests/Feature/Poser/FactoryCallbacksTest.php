<?php

namespace Tests\Feature\Poser;

use Tests\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FactoryCallbacksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_after_making_command_works() {
        $user = UserFactory::new()->make(['remember_token' => 'poser']);
        $this->assertEquals('foobar', $user->remember_token);
    }

    /** @test */
    public function the_after_create_command_works() {
        $user = UserFactory::new()->create(['remember_token' => 'poser']);
        $this->assertCount(20, $user->groups);
    }

    /** @test */
    public function the_after_making_state_command_works() {
        $user = UserFactory::new()->as('unverified')->make(['remember_token' => 'poser']);
        $this->assertEquals('makingStateFoobar', $user->remember_token);
    }

    /** @test */
    public function the_after_creating_state_command_works() {
        $user = UserFactory::new()->as('unverified')->create(['remember_token' => 'poser']);
        $this->assertCount(40, $user->groups);

        $otherUser = UserFactory::new()->as('johndoe')->create(['remember_token' => 'poser']);
        $this->assertCount(20, $otherUser->groups);
    }
}
