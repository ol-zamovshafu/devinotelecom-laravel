<?php

namespace NotificationChannels\DevinotelecomSms\Test;

use Exception;
use Mockery as M;
use PHPUnit\Framework\TestCase;
use NotificationChannels\Devinotelecom\DevinotelecomSms;
use NotificationChannels\Devinotelecom\DevinotelecomSmsChannel;
use NotificationChannels\Devinotelecom\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;
use Zamovshafu\Devinotelecom\ShortMessage;
use Zamovshafu\Devinotelecom\Http\Responses\ResponseInterface;

class DevinotelecomSmsChannelTest extends TestCase
{
    /**
     * @var DevinotelecomSmsChannel
     */
    private $channel;

    /**
     * @var ResponseInterface
     */
    private $responseInterface;

    public function setUp()
    {
        parent::setUp();

        $this->channel = new DevinotelecomSmsChannel();
        $this->responseInterface = M::mock(ResponseInterface::class);
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testItSendsNotification()
    {
        DevinotelecomSms::shouldReceive('sendShortMessage')
            ->once()
            ->with('+1234567890', 'foo')
            ->andReturn($this->responseInterface);

        $this->assertNull($this->channel->send(new TestNotifiable(), new TestNotification()));
    }

    public function testItSendsNotificationWithShortMessage()
    {
        $message = new TestNotificationWithShortMessage();

        DevinotelecomSms::shouldReceive('sendShortMessage')
            ->once()
            ->andReturn($this->responseInterface);

        $this->assertNull($this->channel->send(new TestNotifiable(), $message));
    }

    public function testItThrowsExceptionIfNoReceiverProvided()
    {
        $e = null;

        try {
            $this->channel->send(new EmptyTestNotifiable(), new TestNotification());
        } catch (Exception $e) {
        }

        $this->assertInstanceOf(CouldNotSendNotification::class, $e);
    }
}

class TestNotifiable
{
    public function routeNotificationFor()
    {
        return '+1234567890';
    }
}

class TestNotification extends Notification
{
    public function via($notifiable)
    {
        return [DevinotelecomSmsChannel::class];
    }

    public function toDevinotelecomSms($notifiable)
    {
        return 'foo';
    }
}

class TestNotificationWithShortMessage extends Notification
{
    public function via($notifiable)
    {
        return [DevinotelecomSmsChannel::class];
    }

    public function toDevinotelecomSms($notifiable)
    {
        return new ShortMessage('foo', 'bar');
    }
}

class EmptyTestNotifiable
{
    public function routeNotificationFor()
    {
        return '';
    }
}
