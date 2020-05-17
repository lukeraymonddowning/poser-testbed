<?php

namespace Tests\Feature\Poser;

use App\User;
use Tests\TestCase;
use Tests\Factories\UserFactory;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuickCreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_collection_can_be_created_if_attributes_are_passed_to_the_craft_method() {
        $items = UserFactory::craft(5, ['name' => 'Test']);

        $this->assertInstanceOf(Collection::class, $items);
        $this->assertCount(5, $items);
        $items->each(fn($item) => $this->assertEquals("Test", $item->name));
    }

    /** @test */
    public function multiple_attributes_can_be_passed() {
        $items = UserFactory::craft(2, ['name' => 'Foo'], ['name' => 'Bar']);

        $this->assertInstanceOf(Collection::class, $items);
        $this->assertCount(2, $items);

        $this->assertEquals("Foo", $items->first()->name);
        $this->assertEquals("Bar", $items->last()->name);
    }

    /** @test */
    public function a_single_instance_can_be_created_if_attributes_are_passed_to_the_craftOne_method() {
        $item = UserFactory::craft(['name' => 'Test']);

        $this->assertInstanceOf(User::class, $item);
        $this->assertEquals('Test', $item->name);
    }

    /** @test */
    public function a_single_instance_can_be_created_if_empty_attributes_are_passed_to_the_craftOne_method() {
        $item = UserFactory::craft([]);
        $this->assertInstanceOf(User::class, $item);

        $item = UserFactory::craft();
        $this->assertInstanceOf(User::class, $item);
    }
}
