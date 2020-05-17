<?php

namespace Tests\Feature\Poser;

use App\Role;
use Tests\Factories\TagFactory;
use Tests\Factories\UserFactory;
use Tests\Factories\RoleFactory;
use Illuminate\Support\Facades\DB;
use Tests\Factories\CommentFactory;
use Tests\Factories\CustomerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BelongsToManyTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_can_save_belongs_to_many_relationships()
    {
        $user = UserFactory::new()->withRoles([
            'name' => 'test'
        ])();

        $this->assertEquals('test', $user->roles->first()->name);

        $role = RoleFactory::new()->withUsers(5)();
        $this->assertCount(5, $role->users);
    }

    /** @test */
    public function it_can_save_information_on_the_pivot_table()
    {
        $expiry = now();
        $user = UserFactory::new()->withRoles(RoleFactory::new()->withPivotAttributes([
            'expires_at' => $expiry
        ]))();

        $this->assertDatabaseHas('role_user', [
            'user_id' => $user->id,
            'expires_at' => $expiry
        ]);
    }

    /** @test */
    public function it_can_save_information_on_the_pivot_table_for_polymorphic_relationships()
    {
        $user = UserFactory::new()->withCustomers(
            CustomerFactory::new()->withTags(
                TagFactory::new()->withPivotAttributes(['info' => 'foobar'])
            )
        )();

        $this->assertDatabaseHas('taggables', [
            'taggable_id' => $user->id,
            'info' => 'foobar'
        ]);
    }

    /** @test */
    public function it_can_accept_multiple_attribute_sets_for_pivot_data() {
        $user = UserFactory::new()->withCustomers(
            CustomerFactory::new()->withTags(
                TagFactory::times(3)->withPivotAttributes(
                    ['info' => 'foo'],
                    ['info' => 'bar'],
                    ['info' => 'sam']
                )
            )
        )();

        $this->assertDatabaseHas('taggables', [
            'taggable_id' => $user->id,
            'info' => 'foo'
        ]);

        $this->assertDatabaseHas('taggables', [
            'taggable_id' => $user->id,
            'info' => 'bar'
        ]);

        $this->assertDatabaseHas('taggables', [
            'taggable_id' => $user->id,
            'info' => 'sam'
        ]);
    }

    /** @test */
    public function if_there_are_less_pivot_attribute_sets_than_models_it_loops_through_them() {
        $user = UserFactory::new()->withCustomers(
            CustomerFactory::new()->withTags(
                TagFactory::times(30)->withPivotAttributes(
                    ['info' => 'foo'],
                    ['info' => 'bar'],
                    ['info' => 'sam']
                )
            )
        )();

        $this->assertCount(10, $user->customers->first()->tags()->withPivot('info')->get()->filter(fn($tag) => $tag->pivot->info == "foo"));
        $this->assertCount(10, $user->customers->first()->tags()->withPivot('info')->get()->filter(fn($tag) => $tag->pivot->info == "bar"));
        $this->assertCount(10, $user->customers->first()->tags()->withPivot('info')->get()->filter(fn($tag) => $tag->pivot->info == "sam"));
    }

    /** @test */
    public function if_there_are_more_pivot_attribute_sets_than_models_it_will_skip_the_later_ones() {
        $user = UserFactory::new()->withCustomers(
            CustomerFactory::new()->withTags(
                TagFactory::times(2)->withPivotAttributes(
                    ['info' => 'foo'],
                    ['info' => 'bar'],
                    ['info' => 'sam']
                )
            )
        )();

        $this->assertDatabaseHas('taggables', [
            'taggable_id' => $user->id,
            'info' => 'foo'
        ]);

        $this->assertDatabaseHas('taggables', [
            'taggable_id' => $user->id,
            'info' => 'bar'
        ]);

        $this->assertDatabaseMissing('taggables', [
            'taggable_id' => $user->id,
            'info' => 'sam'
        ]);
    }
}
