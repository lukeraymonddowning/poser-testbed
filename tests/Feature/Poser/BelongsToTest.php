<?php

namespace Tests\Feature\Poser;

use Tests\Factories\BookFactory;
use Tests\Factories\UserFactory;
use Tests\Factories\CustomerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BelongsToTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_saved_to_a_customer() {
        $book = BookFactory::new()->forCustomer(CustomerFactory::new()->forUser(UserFactory::new()))->create();

        $this->assertNotEmpty($book->customer);
    }
}
