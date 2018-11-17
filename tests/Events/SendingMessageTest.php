<?php

namespace NotificationChannels\Devinotelecom\Test\Events;

use Mockery as M;
use PHPUnit\Framework\TestCase;
use Zamovshafu\Devinotelecom\ShortMessage;
use NotificationChannels\Devinotelecom\Events\SendingMessage;

class SendingMessageTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        M::close();

        parent::tearDown();
    }

    public function testItConstructs()
    {
        $shortMessage = M::mock(ShortMessage::class);

        $event = new SendingMessage($shortMessage);

        $this->assertInstanceOf(SendingMessage::class, $event);
        $this->assertEquals($shortMessage, $event->message);
    }
}
