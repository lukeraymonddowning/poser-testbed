<?php


namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use Tests\Factories\UserFactory;
use Tests\Factories\BookFactory;
use Tests\Factories\AddressFactory;
use Tests\Factories\CustomerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PoserExampleTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function user_has_customers()
    {
        $user = UserFactory::new()
            ->withAddress(AddressFactory::new())
            ->withCustomers(CustomerFactory::times(30)->withBooks(BookFactory::times(5)))
            ->create();

        $this->assertCount(30, $user->customers);
        $this->assertCount(150, Book::all());
        $this->assertNotEmpty($user->address);
    }

}
