<?php

namespace Tests\Feature\Poser;

use Tests\Factories\UserFactory;
use Tests\Factories\CustomerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OneToManyPolymorphicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_have_many_comments() {
        $user = UserFactory::new()->withComments(10)();

        $this->assertCount(10, $user->comments);
    }

    /** @test */
    public function a_customer_can_have_many_comments() {
        $customer = CustomerFactory::new()->withComments(25)->forUser(UserFactory::new()())();

        $this->assertCount(25, $customer->comments);
    }
}
