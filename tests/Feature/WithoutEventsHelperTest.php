<?php

namespace Tests\Feature;

use App\Customer;
use App\Events\LogEventFired;
use Tests\Factories\UserFactory;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WithoutEventsHelperTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function when_not_used_events_fire_as_expected() {
        Event::fake();

        $user = UserFactory::new()();

        Event::assertDispatched(LogEventFired::class);
    }

    /** @test */
    public function events_can_be_disabled_with_a_helper_method() {
        Event::fake();

        $user = UserFactory::new()->withoutEvents()();

        Event::assertNotDispatched(LogEventFired::class);
    }

}
