<?php

namespace NotificationChannels\Devinotelecom\Events;

use Zamovshafu\Devinotelecom\ShortMessage;
use Zamovshafu\Devinotelecom\Http\Responses\ResponseInterface;

/**
 * Class MessageWasSent.
 */
class MessageWasSent
{
    /**
     * The sms message.
     *
     * @var ShortMessage
     */
    public $message;

    /**
     * The Api response implementation.
     *
     * @var ResponseInterface
     */
    public $response;

    /**
     * MessageWasSent constructor.
     *
     * @param ShortMessage      $message
     * @param ResponseInterface $response
     */
    public function __construct(ShortMessage $message, ResponseInterface $response)
    {
        $this->message = $message;
        $this->response = $response;
    }
}
