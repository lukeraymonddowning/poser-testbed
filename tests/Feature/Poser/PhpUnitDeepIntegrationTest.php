<?php

namespace Tests\Feature\Poser;

use App\User;
use Tests\Factories\UserFactory;
use Tests\Factories\BookFactory;
use Tests\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PhpUnitDeepIntegrationTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_can_call_assertions_directly()
    {
        UserFactory::assertEquals('Luke Downing', 'name')(['name' => 'Luke Downing']);
    }

    /** @test */
    public function it_works_with_a_callable()
    {
        UserFactory::assertEquals('Luke Downing', fn($user) => $user->name)(['name' => 'Luke Downing']);
    }

    /** @test */
    public function it_can_assert_counts()
    {
        UserFactory::withCustomers(5)->assertCount(5, 'customers')();
    }

    /** @test */
    public function it_works_with_collections()
    {
        UserFactory::times(5)->assertEquals('Luke Downing', 'name')(['name' => 'Luke Downing']);
    }

    /** @test */
    public function collections_can_use_a_callable()
    {
        UserFactory::times(5)->withCustomers(5)->assertCount(
            5,
            function (User $user) {
                return $user->customers;
            }
        )();
    }

    /** @test */
    public function an_untyped_function_in_the_assertion_is_passed_the_whole_collection()
    {
        UserFactory::times(10)->assertTrue(
            function ($users) {
                return $users->count() == 10;
            }
        )();
    }

    /** @test */
    public function it_works_with_nested_models()
    {
        UserFactory::withCustomers(
            CustomerFactory::times(5)
                           ->withAttributes(['name' => 'Foobar'])
                           ->assertEquals('Foobar', 'name')
        )();

        UserFactory::withCustomers(
            CustomerFactory::new()
                           ->withAttributes(['name' => 'Foobar'])
                           ->assertEquals('Foobar', 'name')
                           ->assertInstanceOf(User::class, fn($customer) => $customer->user)
        )();
    }

    /** @test */
    public function it_works_with_for_relationships()
    {
        CustomerFactory::times(5)
                       ->forUser(UserFactory::new()->withAttributes(['name' => 'Ron'])->assertEquals('Ron', 'name'))();
    }

    /** @test */
    public function it_can_handle_assertions_at_different_levels()
    {
        UserFactory::withCustomers(
            CustomerFactory::times(10)
                           ->withAttributes(['name' => 'John Doe'])
                           ->withBooks(10)
                           ->assertCount(10, 'books')
                           ->assertEquals('John Doe', 'name')
        )->assertCount(10, 'customers')->assertCount(10, fn($user) => $user->customers->first()->books)();
    }

    /** @test */
    public function assertEmpty_test()
    {
        UserFactory::new()->withoutDefaults()->assertEmpty('customers')->assertNotNull('customers')();
    }

    /** @test */
    public function initial_test_rewritten()
    {
        UserFactory::withCustomers(CustomerFactory::times(30))
                   ->assertCount(30, 'customers')();
    }
}
