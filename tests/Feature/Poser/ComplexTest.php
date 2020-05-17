<?php

namespace Tests\Feature\Poser;

use App\User;
use App\Address;
use App\Customer;
use App\Models\Book;
use Tests\Factories\UserFactory;
use Tests\Factories\BookFactory;
use Illuminate\Support\Facades\DB;
use Tests\Factories\AddressFactory;
use Tests\Factories\CustomerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ComplexTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_can_be_invoked_to_create()
    {
        $customer = CustomerFactory::new()->forUser(UserFactory::new()->create())();

        $this->assertNotEmpty($customer->id);
    }

    /** @test */
    public function it_can_handle_complex_mappings()
    {
        CustomerFactory::times(20)->withBooks(5)->forUser(UserFactory::new()->withoutDefaults('customers'))();

        $this->assertCount(100, Book::all());
        $this->assertCount(20, Customer::all());
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function it_can_be_chained()
    {
        $this->withoutExceptionHandling();
        UserFactory::new()
                   ->withAddress()
                   ->withCustomers(CustomerFactory::times(20)->withBooks(5))();

        $this->assertCount(100, Book::all());
        $this->assertCount(20, Customer::all());
        $this->assertCount(1, User::all());
        $this->assertCount(1, Address::all());
    }

    /** @test */
    public function the_first_instance_can_be_a_multiple()
    {
        UserFactory::times(10)
                   ->withAddress()
                   ->withCustomers(CustomerFactory::times(20)->withBooks(5))();

        $this->assertCount(1000, Book::all());
        $this->assertCount(200, Customer::all());
        $this->assertCount(10, User::all());
        $this->assertCount(10, Address::all());
    }

    /** @test */
    public function test()
    {
        $user = factory(User::class)->times(10)->create();
        $user->each(
            function ($user) {
                $user->address()->save(factory(Address::class)->make());
                $customers = factory(Customer::class)->times(20)->make();
                $user->customers()->saveMany($customers);
                $user->customers->each(
                    function ($customer) {
                        $customer->books()->saveMany(factory(Book::class)->times(5)->make());
                    }
                );
            }
        );

        $this->assertCount(1000, Book::all());
        $this->assertCount(200, Customer::all());
        $this->assertCount(10, User::all());
        $this->assertCount(10, Address::all());
    }

    /** @test */
    public function the_same_relation_can_be_handled_twice()
    {
        $user = UserFactory::new()
                           ->withCustomers(CustomerFactory::times(5)->withAttributes(['name' => "Joe"]))
                           ->withCustomers(CustomerFactory::times(5)->withAttributes(['name' => "Jane"]))
                           ->create();

        $this->assertCount(10, $user->customers);
        $this->assertCount(5, $user->customers->filter(fn($customer) => $customer->name == "Joe"));
        $this->assertCount(5, $user->customers->filter(fn($customer) => $customer->name == "Jane"));
    }

}
