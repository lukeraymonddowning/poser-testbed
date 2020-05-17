<?php

namespace Tests\Feature;

use App\Tag;
use App\User;
use App\Address;
use App\Customer;
use App\Models\Book;
use Illuminate\Support\Str;
use Tests\Factories\TagFactory;
use Tests\Factories\UserFactory;
use Tests\Factories\BookFactory;
use Illuminate\Support\Facades\File;
use Tests\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function user_has_customers()
    {
        $user = factory(User::class)->create();
        $user->address()->save(factory(Address::class)->make());
        $user->customers()->saveMany(factory(Customer::class)->times(30)->make());
        $user->customers->each(
            function ($customer) {
                $customer->books()->saveMany(factory(Book::class, 5)->make());
            }
        );

        $this->assertCount(30, $user->customers);
        $this->assertCount(150, Book::all());
        $this->assertNotEmpty($user->address);
    }

    /** @test */
    public function test()
    {
        $achievements = TagFactory::times(10)();

        UserFactory::withCustomers(CustomerFactory::times(15)->withTags($achievements))
                   ->withCustomers(CustomerFactory::times(20))();

        dd(Tag::all()->count());
    }

// Without Poser

/** @test */
function a_user_may_have_customers()
{
    $userWithCustomers = factory(User::class)->create();
    $userWithCustomers->customers()->saveMany(factory(Customer::class)->times(30)->make());

    $userWithoutCustomers = factory(User::class)->create();

    $this->assertCount(30, $userWithCustomers->customers);
    $this->assertTrue($userWithoutCustomers->customers->isEmpty());
}

// With Poser

/** @test */
function a_user_may_have_customers()
{
    UserFactory::withCustomers(30)->assertCount(30, 'customers')();
    UserFactory::assertTrue(fn($user) => $user->customers->isEmpty())();
}

}
