<?php

namespace Tests\Feature;

use Tests\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HasMethodTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function there_is_a_has_method() {
        $user = UserFactory::new()->has(1, 'customers')();

        $this->assertCount(1, $user->customers);
    }

    /** @test */
    public function it_can_receive_a_count() {
        $user = UserFactory::new()->has(10, 'customers')();

        $this->assertCount(10, $user->customers);
    }

    /** @test */
    public function it_can_receive_attributes() {
        $user = UserFactory::new()->has(10, 'customers', ['name' => 'Joe Bloggs'])();

        $user->customers->each(function($customer) {
            $this->assertEquals('Joe Bloggs', $customer->name);
        });
    }

    /** @test */
    public function there_is_a_with_method() {
        $user = UserFactory::new()->with(1, 'customers')();

        $this->assertCount(1, $user->customers);
    }

    /** @test */
    public function the_with_method_can_receive_a_count() {
        $user = UserFactory::new()->with(10, 'customers')();

        $this->assertCount(10, $user->customers);
    }

    /** @test */
    public function the_with_method_can_receive_attributes() {
        $user = UserFactory::new()->has(10, 'customers', ['name' => 'Joe Bloggs'])();

        $user->customers->each(function($customer) {
            $this->assertEquals('Joe Bloggs', $customer->name);
        });
    }

}
