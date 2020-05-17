<?php

namespace Tests\Feature\Poser;

use App\User;
use App\Address;
use App\Customer;
use Tests\Factories\UserFactory;
use Tests\Factories\AddressFactory;
use Tests\Factories\CustomerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DefaultTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     * @see UserFactory
     */
    public function if_there_is_a_default_function_for_a_relationship_it_creates_it_when_persisting_the_model()
    {
        $user = UserFactory::new()->create();

        $this->assertInstanceOf(Address::class, $user->address);
    }

    /**
     * @test
     * @see UserFactory
     */
    public function if_the_relationship_is_already_defined_the_default_does_not_take_effect()
    {
        $user = UserFactory::new()
                           ->withAddress(AddressFactory::new()->withAttributes(['line_1' => "Default Not Set"]))
                           ->create();

        $this->assertEquals("Default Not Set", $user->address->line_1);
        $this->assertCount(1, Address::all());
    }

    /**
     * @test
     * @see CustomerFactory
     */
    public function defaults_also_work_in_for_relationships()
    {
        $customer = CustomerFactory::new()->create();

        $this->assertEquals("John Doe", $customer->user->name);
    }

    /**
     * @test
     * @see CustomerFactory
     */
    public function if_the_relationship_is_already_defined_in_a_for_relationship_the_default_does_not_take_effect() {
        $customer = CustomerFactory::new()->forUser(UserFactory::new()->withAttributes(['name' => "Foo Bar"]))->create();

        $this->assertEquals("Foo Bar", $customer->user->name);
        $this->assertCount(1, User::all());
    }

    /**
     * @test
     * @see UserFactory
     */
    public function it_works_with_built_models_for_defaults() {
        $user = UserFactory::new()->create();

        $this->assertCount(30, $user->customers);
        $this->assertCount(30, Customer::all());
    }

    /** @test */
    public function there_is_a_without_defaults_method() {
        $user = UserFactory::new()->withoutDefaults()->create();

        $this->assertEmpty($user->customers);
        $this->assertCount(0, Customer::all());
    }

    /** @test */
    public function the_without_defaults_method_can_be_passed_relationships_to_ignore() {
        $user = UserFactory::new()->withoutDefaults('customers')->create();

        $this->assertEmpty($user->customers);
        $this->assertNotEmpty($user->address);
    }

    /** @test */
    public function the_without_defaults_method_can_be_passed_multiple_relationships_to_ignore() {
        $user = UserFactory::new()->withoutDefaults('customers', 'address')->create();

        $this->assertEmpty($user->customers);
        $this->assertEmpty($user->address);
    }
}
