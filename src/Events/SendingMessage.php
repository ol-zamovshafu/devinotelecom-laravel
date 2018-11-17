<?php

namespace NotificationChannels\Devinotelecom\Events;

use Zamovshafu\Devinotelecom\ShortMessage;

/**
 * Class SendingMessage.
 */
class SendingMessage
{
    /**
     * The DevinotelecomSms message.
     *
     * @var ShortMessage
     */
    public $message;

    /**
     * SendingMessage constructor.
     *
     * @param $message
     */
    public function __construct(ShortMessage $message)
    {
        $this->message = $message;
    }
}
