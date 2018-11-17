<?php

namespace NotificationChannels\Devinotelecom\Test\Events;

use Mockery as M;
use PHPUnit\Framework\TestCase;
use Zamovshafu\Devinotelecom\ShortMessage;
use NotificationChannels\Devinotelecom\Events\MessageWasSent;
use Zamovshafu\Devinotelecom\Http\Responses\ResponseInterface;

class MessageWasSentTest extends TestCase
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
        $response = M::mock(ResponseInterface::class);

        $event = new MessageWasSent($shortMessage, $response);

        $this->assertInstanceOf(MessageWasSent::class, $event);
        $this->assertEquals($shortMessage, $event->message);
        $this->assertEquals($response, $event->response);
    }
}
