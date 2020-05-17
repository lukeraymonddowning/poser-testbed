<?php

namespace Tests\Feature;

use App\User;
use App\Address;
use App\Customer;
use App\Models\Book;
use Tests\Factories\UserFactory;
use Tests\Factories\BookFactory;
use Tests\Factories\AddressFactory;
use Tests\Factories\CustomerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PoserMagicBindingsTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function complex_test_made_easy()
    {
        $users = UserFactory::times(20)
                            ->withAddress()
                            ->withCustomers(CustomerFactory::times(30)->withBooks(5))();

        $this->assertCount(20, $users);
        $this->assertInstanceOf(Address::class, $users->first()->address);
        $this->assertCount(30, $users->first()->customers);
        $this->assertCount(5, $users->first()->customers->first()->books);
    }

    /** @test */
    public function a_user_can_have_customers()
    {
        $user = UserFactory::new()->withCustomers(10)->create();

        $this->assertCount(10, $user->customers);
    }

    /** @test */
    public function a_user_with_an_active_subscription_can_have_up_to_50_customers_with_invoices()
    {
        $user = UserFactory::new()
                           ->withSubscriptions(
                               SubscriptionFactory::new()
                                                  ->withAttributes(['name' => 'Pro'])
                                                  ->withPivotAttributes(['expires_at' => now()->addMonth()])
                           )->withCustomers(CustomerFactory::times(50)->withInvoices(10))
                           ->create();

        $this->assertCount(50, $user->customers);
        $this->assertEquals(50 * 10, Invoice::count());
    }
}
