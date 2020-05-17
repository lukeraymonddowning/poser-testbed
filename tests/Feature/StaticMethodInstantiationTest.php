<?php

namespace Tests\Feature;

use Tests\Factories\UserFactory;
use Tests\Factories\CustomerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StaticMethodInstantiationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function methods_can_be_handled_statically() {
        $user = UserFactory::withCustomers(5)();

        $this->assertCount(5, $user->customers);
    }

    /** @test */
    public function nested_relationships_can_be_handled_statically() {
        $user = UserFactory::withCustomers(CustomerFactory::withBooks(10))();

        $this->assertCount(10, $user->customers->first()->books);
    }

    /** @test */
    public function it_works_with_for_relationships() {
        $customer = CustomerFactory::forUser(UserFactory::new()->withAttributes(['name' => "Joe"]))();

        $this->assertEquals("Joe", $customer->user->name);
    }
}
