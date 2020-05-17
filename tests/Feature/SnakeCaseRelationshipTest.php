<?php

namespace Tests\Feature;

use App\User;
use App\Customer;
use Tests\Factories\UserFactory;
use Tests\Factories\CustomerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SnakeCaseRelationshipTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_resolve_snake_case_for_relationships() {
        $user = UserFactory::new()();
        $customer = CustomerFactory::forSnakeCaseUser($user)->withoutDefaults()();

        $this->assertEquals($user->id, $customer->user->id);
    }

    /** @test */
    public function it_can_resolve_snake_case_with_relationships() {
        $user = UserFactory::withSnakeCaseCustomers(CustomerFactory::times(5))->withoutDefaults()();

        $this->assertCount(5, $user->customers);
    }
}
