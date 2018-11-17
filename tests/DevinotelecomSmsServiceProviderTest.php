<?php

namespace NotificationChannels\Devinotelecom\Test;

use Mockery as M;
use PHPUnit\Framework\TestCase;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Container\ContextualBindingBuilder;
use NotificationChannels\Devinotelecom\DevinotelecomSmsServiceProvider;

class DevinotelecomSmsServiceProviderTest extends TestCase
{
    private $app;
    private $contextualBindingBuilder;

    public function setUp()
    {
        parent::setUp();

        $this->app = M::mock(Application::class);
        $this->contextualBindingBuilder = M::mock(ContextualBindingBuilder::class);
    }

    public function tearDown()
    {
        M::close();

        parent::tearDown();
    }

    /** @test */
    public function itShouldProvideServicesOnBoot()
    {
        $this->app->shouldReceive('bind')->once();
        $this->app->shouldReceive('singleton')->once();

        $provider = new DevinotelecomSmsServiceProvider($this->app);

        $this->assertNull($provider->boot());
    }
}
