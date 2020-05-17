<?php

namespace Tests\Feature\Poser;

use Tests\Factories\UserFactory;
use Tests\Factories\TestFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AttributesTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function there_is_a_with_attributes_method()
    {
        $user = UserFactory::new()->withAttributes(
            [
                'name' => "Joe Bloggs"
            ]
        )->create();

        $this->assertEquals('Joe Bloggs', $user->name);
    }

    /** @test */
    public function the_create_attributes_override_the_with_attributes_method()
    {
        $user = UserFactory::new()->withAttributes(
            [
                'name' => "Joe Bloggs"
            ]
        )->create(
            [
                'name' => "Jane Bloggs"
            ]
        );

        $this->assertDatabaseHas(
            'users',
            [
                'name' => "Jane Bloggs"
            ]
        );
    }

    /** @test */
    public function the_make_attributes_override_the_with_attributes_method()
    {
        $user = UserFactory::new()->withAttributes(
            [
                'name' => "Joe Bloggs"
            ]
        )->make(
            [
                'name' => "Jane Bloggs"
            ]
        );

        $this->assertEquals('Jane Bloggs', $user->name);
    }

    /** @test */
    public function it_can_accept_multiple_arguments()
    {
        $users = UserFactory::times(2)->withAttributes(
            ['name' => "Joe Bloggs"],
            ['name' => "Jane Bloggs"]
        )->create();

        $this->assertEquals('Joe Bloggs', $users->first()->name);
        $this->assertEquals('Jane Bloggs', $users->last()->name);
    }

    /** @test */
    public function if_there_are_more_attributes_than_models_to_create_the_later_attributes_are_ignored()
    {
        $users = UserFactory::times(2)->withAttributes(
            ['name' => "Joe Bloggs"],
            ['name' => "Jane Bloggs"],
            ['name' => "Steve Rogers"]
        )->create();

        $this->assertEquals('Joe Bloggs', $users->first()->name);
        $this->assertEquals('Jane Bloggs', $users->last()->name);
    }

    /** @test */
    public function if_there_are_less_attributes_than_models_to_create_they_are_looped_over()
    {
        $users = UserFactory::times(5)->withAttributes(
            ['name' => "Joe Bloggs"],
            ['name' => "Jane Bloggs"]
        )->create();

        $this->assertEquals('Joe Bloggs', $users[0]->name);
        $this->assertEquals('Jane Bloggs', $users[1]->name);
        $this->assertEquals('Joe Bloggs', $users[2]->name);
        $this->assertEquals('Jane Bloggs', $users[3]->name);
        $this->assertEquals('Joe Bloggs', $users[4]->name);
    }
}
