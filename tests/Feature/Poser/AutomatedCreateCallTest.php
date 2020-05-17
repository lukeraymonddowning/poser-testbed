<?php

namespace Tests\Feature\Poser;

use App\User;
use App\Address;
use App\Customer;
use Tests\Factories\UserFactory;
use Tests\Factories\AddressFactory;
use Tests\Factories\CustomerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AutomatedCreateCallTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function create_is_called_automatically_when_trying_to_access_a_property_that_doesnt_exist()
    {
        $user = UserFactory::new()->withAddress()->withCustomers(10);

        $this->assertCount(10, $user->customers);
        $this->assertInstanceOf(Address::class, $user->address);

        $this->assertCount(1, User::all());
    }

    /** @test */
    public function create_is_called_automatically_when_trying_to_access_a_method_that_doesnt_exist()
    {
        $user = UserFactory::new()->withCustomers(10);

        $user->address()->save(AddressFactory::new()->make());

        $this->assertCount(10, $user->customers);
        $this->assertInstanceOf(Address::class, $user->address);

        $this->assertCount(1, User::all());
    }

    /** @test */
    public function it_works_with_for_relationships()
    {
        $customers = CustomerFactory::times(3)->forUser(UserFactory::new());

        $customers->each(
            function ($customer) {
                $this->assertInstanceOf(User::class, $customer->user);
            }
        );
    }
}
