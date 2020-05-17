<?php

namespace Tests\Feature\Poser;

use Tests\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Lukeraymonddowning\Poser\Exceptions\ModelNotBuiltException;

class ErrorTesting extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_throws_a_helpful_error_message_when_you_try_to_access_a_model_property_on_the_factory() {
        $this->expectException(ModelNotBuiltException::class);
        UserFactory::new()->name;
    }

    /** @test */
    public function it_throws_a_helpful_error_message_when_you_try_to_access_a_model_method_on_the_factory() {
        $this->withoutExceptionHandling();
//        $this->expectException(ModelNotBuiltException::class);
        UserFactory::new()->badData();
    }
}
