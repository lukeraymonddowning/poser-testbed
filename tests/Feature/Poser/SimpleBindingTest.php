<?php

namespace Tests\Feature\Poser;

use App\Customer;
use Tests\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Lukeraymonddowning\Poser\Exceptions\ArgumentsNotSatisfiableException;

class SimpleBindingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_work_out_the_binding_automatically_if_there_is_a_corresponding_factory() {
        $userWithAddress = UserFactory::new()->withAddress()();
        $this->assertNotEmpty($userWithAddress->address);
    }

    /** @test */
    public function it_can_work_out_the_binding_on_has_many_relationships() {
        $userWithCustomers = UserFactory::new()->withCustomers()();

        $this->assertNotEmpty($userWithCustomers->customers);
    }

    /** @test */
    public function if_an_integer_is_passed_to_a_has_many_relationship_it_creates_that_many_automatically() {
        $userWithCustomers = UserFactory::new()->withCustomers(15)();

        $this->assertNotEmpty($userWithCustomers->customers);
        $this->assertCount(15, $userWithCustomers->customers);
        $this->assertCount(15, Customer::all());
    }

    /** @test */
    public function it_can_be_passed_an_array_of_attributes() {
        $userWithAddress = UserFactory::new()->withAddress([
            'line_1' => 'foo bar lane'
        ])();

        $this->assertEquals('foo bar lane', $userWithAddress->address->line_1);
    }

    /** @test */
    public function it_can_be_created_with_a_multiplier_and_passed_an_array_of_attributes() {
        $userWithCustomers = UserFactory::new()->withCustomers(30, [
            'name' => "Joe Bloggs"
        ])();

        $userWithCustomers->customers->each(function($customer) {
            $this->assertEquals('Joe Bloggs', $customer->name);
        });
    }

    /** @test */
    public function it_throws_an_error_if_the_binding_could_not_be_found() {
        $this->expectException(ArgumentsNotSatisfiableException::class);
        UserFactory::new()->withPerson()();
    }
}
