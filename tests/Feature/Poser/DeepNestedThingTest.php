<?php

namespace Tests\Feature\Poser;

use App\Models\DeepNestedThing\DeepNestedThing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Factories\Models\DeepNestedThing\DeepNestedThingFactory;

class DeepNestedThingTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_can_be_created() {
        $deepNestedThing = DeepNestedThingFactory::new()();

        $this->assertCount(1, DeepNestedThing::all());
    }

}
