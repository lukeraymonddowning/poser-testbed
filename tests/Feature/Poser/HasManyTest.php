<?php

namespace Tests\Feature\Poser;

use Tests\Factories\UserFactory;
use Tests\Factories\BookFactory;
use Tests\Factories\CustomerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HasManyTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_user_can_have_many_customers() {
        $user = UserFactory::new()->withCustomers(20)->create();
        $this->assertCount(20, $user->customers);
    }

    /** @test */
    public function a_user_can_have_one_customer() {
        $user = UserFactory::new()->withCustomers()->create();
        $this->assertCount(1, $user->customers);
    }

    /** @test */
    public function a_customer_can_have_many_books() {
        $customer = CustomerFactory::new()->forUser(UserFactory::new())->withBooks(30)->create();
        $this->assertCount(30, $customer->books);
    }

    /** @test */
    public function a_customer_can_have_one_book() {
        $customer = CustomerFactory::new()->withBooks()->forUser(UserFactory::new())->create();
        $this->assertCount(1, $customer->books);
    }

    /** @test */
    public function the_relationship_doesnt_have_to_call_make() {
        $user = UserFactory::new()->withCustomers(20)->create();
        $this->assertCount(20, $user->customers);

        $anotherUser = UserFactory::new()->withCustomers()->create();
        $this->assertCount(1, $anotherUser->customers);
    }

}
