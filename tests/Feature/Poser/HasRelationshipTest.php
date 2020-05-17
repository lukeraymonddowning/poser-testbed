<?php

namespace Tests\Feature\Poser;

use App\Address;
use Tests\Factories\UserFactory;
use Tests\Factories\CustomerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HasRelationshipTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_supports_the_has_syntax_for_relationships() {
        $user = UserFactory::new()->hasAddress()();
        $this->assertInstanceOf(Address::class, $user->address);

        $customers = CustomerFactory::times(10)->hasBooks(5)->forUser(UserFactory::new()())();
        $customers->each(function($customer) {
            $this->assertCount(5, $customer->books);
        });
    }

    /** @test */
    public function a_user_has_customers() {
        $user = UserFactory::new()->withAddress()->hasCustomers(10)();

        $this->assertCount(10, $user->customers);
    }
}
