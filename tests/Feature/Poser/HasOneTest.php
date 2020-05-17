<?php

namespace Tests\Feature\Poser;

use Tests\Factories\UserFactory;
use Tests\Factories\BookFactory;
use Tests\Factories\AddressFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HasOneTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function has_one_relationships_can_be_created() {
        $user = UserFactory::new()->withAddress(AddressFactory::new())->create();
        $this->assertNotEmpty($user->address);
    }

}
