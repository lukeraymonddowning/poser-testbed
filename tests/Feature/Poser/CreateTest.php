<?php

namespace Tests\Feature\Poser;

use App\User;
use Tests\Factories\Customer;
use Tests\Factories\UserFactory;
use Tests\Factories\BookFactory;
use Tests\Factories\CustomerFactory;
use Tests\Factories\CustomNameFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Lukeraymonddowning\Poser\Exceptions\ArgumentsNotSatisfiableException;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_users() {
        $user = UserFactory::new()->create([
            'email' => 'foo@bar.com'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'foo@bar.com'
        ]);
    }

    /** @test */
    public function it_can_create_customers() {
        $customer = CustomerFactory::new()->forUser(UserFactory::new())([
            'name' => "Joe Bloggs"
        ]);

        $this->assertDatabaseHas('customers', [
            'name' => "Joe Bloggs"
        ]);
    }

    /** @test */
    public function it_can_create_books() {
        $book = BookFactory::new()->forCustomer(CustomerFactory::new()->forUser(UserFactory::new()))([
            'name' => 'Lorem Ipsum'
        ]);

        $this->assertDatabaseHas('books', [
            'name' => 'Lorem Ipsum'
        ]);
    }

    /** @test */
    public function it_works_if_there_is_no_factory_suffix() {
        $customer = Customer::new()->forUser(UserFactory::new())([
            'name' => "Joe Bloggs"
        ]);

        $this->assertDatabaseHas('customers', [
            'name' => "Joe Bloggs"
        ]);
    }

    /** @test */
    public function it_throws_an_exception_if_there_are_no_compatible_arguments_found_in_the_relationship_method() {
        $this->expectException(ArgumentsNotSatisfiableException::class);
        UserFactory::new()->withCustom()->create();
    }

    /** @test */
    public function create_command_name_binding() {
        $customer = CustomNameFactory::new()->forUser(UserFactory::new()())();

        $this->assertNotEmpty($customer->name);
    }

    /** @test */
    public function it_can_accept_multiple_attributes() {
        UserFactory::times(2)->create(['name' => "Joe Bloggs"], ['name' => "Jane Bloggs"]);

        $this->assertDatabaseHas('users', ['name' => "Joe Bloggs"]);
        $this->assertDatabaseHas('users', ['name' => "Jane Bloggs"]);
    }

    /** @test */
    public function it_can_accept_multiple_attributes_for_relationships() {
        $user = UserFactory::new()->withCustomers(CustomerFactory::times(2)->withAttributes(['name' => "Joe Bloggs"], ['name' => "Jane Bloggs"]))();

        $this->assertDatabaseHas('customers', ['name' => "Joe Bloggs"]);
        $this->assertDatabaseHas('customers', ['name' => "Jane Bloggs"]);
        $this->assertEquals("Joe Bloggs", $user->customers->first()->name);
        $this->assertEquals("Jane Bloggs", $user->customers->last()->name);
    }

    /** @test */
    public function it_can_accept_multiple_attributes_for_relationships_using_the_invoke_method() {
        $user = UserFactory::new()->withCustomers(CustomerFactory::times(2)(['name' => "Joe Bloggs"], ['name' => "Jane Bloggs"]));

        $this->assertDatabaseHas('customers', ['name' => "Joe Bloggs"]);
        $this->assertDatabaseHas('customers', ['name' => "Jane Bloggs"]);
        $this->assertEquals("Joe Bloggs", $user->customers->first()->name);
        $this->assertEquals("Jane Bloggs", $user->customers->last()->name);
    }

    /** @test */
    public function it_can_accept_multiple_attributes_for_relationships_using_magic_bindings() {
        $user = UserFactory::new()->withCustomers(2, ['name' => "Joe Bloggs"], ['name' => "Jane Bloggs"])();

        $this->assertDatabaseHas('customers', ['name' => "Joe Bloggs"]);
        $this->assertDatabaseHas('customers', ['name' => "Jane Bloggs"]);
        $this->assertEquals("Joe Bloggs", $user->customers->first()->name);
        $this->assertEquals("Jane Bloggs", $user->customers->last()->name);
    }

    /** @test */
    public function if_there_are_more_attributes_than_models_to_create_the_later_attributes_are_ignored() {
        UserFactory::times(2)->create(['name' => "Joe Bloggs"], ['name' => "Jane Bloggs"], ['name' => 'Steve Rogers']);

        $this->assertDatabaseHas('users', ['name' => "Joe Bloggs"]);
        $this->assertDatabaseHas('users', ['name' => "Jane Bloggs"]);
        $this->assertDatabaseMissing('users', ['name' => "Steve Rogers"]);
    }

}
