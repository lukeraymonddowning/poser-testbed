<?php

namespace Tests\Feature\Poser;

use App\Tag;
use App\Customer;
use Tests\Factories\UserFactory;
use Tests\Factories\CustomerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManyToManyPolymorphicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_have_the_same_tag_that_a_customer_has() {
        $user = UserFactory::new()->withTags(5)();

        $this->assertCount(5, $user->tags);

        $customer = CustomerFactory::new()->forUser($user)->withTags($user->tags->first())();
        $this->assertInstanceOf(Tag::class, $customer->tags->first());
    }
}
