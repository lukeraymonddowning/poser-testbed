<?php

namespace Tests\Feature\Poser;

use App\User;
use App\Customer;
use App\Models\Book;
use Tests\Factories\UserFactory;
use Tests\Factories\AddressFactory;
use Tests\Factories\CustomerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AfterCreatingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_works_as_expected() {
        $user = UserFactory::new()->withoutDefaults()->afterCreating(function($user) {
            $user->customers()->saveMany(factory(Customer::class, 10)->make());
        })();

        $this->assertCount(10, $user->customers);
    }

    /** @test */
    public function it_works_with_multiple_models() {
        $users = UserFactory::times(10)->withoutDefaults()->afterCreating(function($user) {
            $user->customers()->saveMany(factory(Customer::class, 10)->make());
        })();

        $users->each(function($user) {
            $this->assertCount(10, $user->customers);
        });
    }

    /** @test */
    public function it_works_on_nested_relationships() {
        $user = UserFactory::new()->withCustomers(CustomerFactory::times(10)->afterCreating(function($customer) {
            $customer->books()->saveMany(factory(Book::class, 5)->make());
        }))();

        $user->customers->each(function($customer) {
            $this->assertCount(5, $customer->books);
        });
    }

    /** @test */
    public function it_works_on_single_models() {
        $user = UserFactory::new()->withAddress(AddressFactory::new()->afterCreating(function($address) {
            $address->delete();
        }))();

        $this->assertEmpty($user->address);
    }

    /** @test */
    public function the_nested_relationship_receives_the_created_model_and_the_parent() {
        $user = UserFactory::new()->withCustomers(CustomerFactory::new()->afterCreating(function($customer, $user) {
            $this->assertInstanceOf(User::class, $user);
            $this->assertInstanceOf(Customer::class, $customer);
        }))();
    }
}
