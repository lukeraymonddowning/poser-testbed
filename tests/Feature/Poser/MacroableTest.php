<?php

namespace Tests\Feature\Poser;

use Tests\TestCase;
use Tests\Factories\UserFactory;
use Lukeraymonddowning\Poser\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MacroableTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_may_have_macroable_static_methods_added()
    {
        Factory::macro(
            'items',
            function ($count) {
                return static::times($count);
            }
        );

        $this->assertEquals(10, (UserFactory::items(10)())->count());
    }

    /** @test */
    public function it_may_have_macroable_standard_methods_added()
    {
        Factory::macro(
            'getModelCount',
            function () {
                return $this->count;
            }
        );

        $this->assertEquals(10, UserFactory::times(10)->getModelCount());
    }
}
