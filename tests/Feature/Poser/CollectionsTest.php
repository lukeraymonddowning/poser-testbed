<?php

namespace Tests\Feature\Poser;

use Tests\Factories\Customer;
use Tests\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CollectionsTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_collection_of_users() {
        $users = UserFactory::times(10)->create();
        $this->assertCount(10, $users);
    }

    /** @test */
    public function it_can_create_a_collection_of_customers() {
        $customers = Customer::times(10)->forUser(UserFactory::new())->create();
        $this->assertCount(10, $customers);
    }

}
