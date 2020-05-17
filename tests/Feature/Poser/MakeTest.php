<?php

namespace Tests\Feature\Poser;

use Tests\Factories\UserFactory;
use Tests\Factories\BookFactory;
use Tests\Factories\CustomerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MakeTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_can_make_a_user() {
        $user = UserFactory::new()->make([
            'name' => "Joe Bloggs"
        ]);

        $this->assertEquals("Joe Bloggs", $user->name);
        $this->assertNull($user->id);
    }

    /** @test */
    public function it_can_make_a_customer() {
        $customer = CustomerFactory::new()->make([
            'name' => "Joe Bloggs"
        ]);

        $this->assertEquals("Joe Bloggs", $customer->name);
        $this->assertNull($customer->id);
    }

    /** @test */
    public function it_can_make_a_book() {
        $book = BookFactory::new()->make([
            'name' => "Lorem Ipsum"
        ]);

        $this->assertEquals("Lorem Ipsum", $book->name);
        $this->assertNull($book->id);
    }

    /** @test */
    public function it_can_accept_multiple_attributes() {
        $users = UserFactory::times(2)->make(['name' => "Joe Bloggs"], ['name' => "Jane Bloggs"]);

        $this->assertEquals("Joe Bloggs", $users->first()->name);
        $this->assertEquals("Jane Bloggs", $users->last()->name);
    }

    /** @test */
    public function if_there_are_more_attributes_than_models_to_make_the_later_attributes_are_ignored() {
        $users = UserFactory::times(2)->make(['name' => "Joe Bloggs"], ['name' => "Jane Bloggs"], ['name' => 'Steve Rogers']);

        $this->assertEquals("Joe Bloggs", $users->first()->name);
        $this->assertEquals("Jane Bloggs", $users->last()->name);
    }

    /** @test */
    public function if_there_are_less_attributes_than_models_to_create_they_are_looped_over() {
        $users = UserFactory::times(10)->withAttributes(
            ['name' => "Joe Bloggs"],
            ['name' => "Jane Bloggs"],
            ['name' => "Steve Rogers"]
        )->create();

        $this->assertEquals('Joe Bloggs', $users[0]->name);
        $this->assertEquals('Jane Bloggs', $users[1]->name);
        $this->assertEquals('Steve Rogers', $users[2]->name);
        $this->assertEquals('Joe Bloggs', $users[3]->name);
        $this->assertEquals('Jane Bloggs', $users[4]->name);
        $this->assertEquals('Steve Rogers', $users[5]->name);
        $this->assertEquals('Joe Bloggs', $users[6]->name);
        $this->assertEquals('Jane Bloggs', $users[7]->name);
        $this->assertEquals('Steve Rogers', $users[8]->name);
        $this->assertEquals('Joe Bloggs', $users[9]->name);

    }

}
