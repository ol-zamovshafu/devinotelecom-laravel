<?php

namespace NotificationChannels\Devinotelecom;

use Zamovshafu\Devinotelecom\ShortMessage;
use Illuminate\Support\Facades\Facade;
use Zamovshafu\Devinotelecom\ShortMessageCollection;
use Zamovshafu\Devinotelecom\Http\Responses\ResponseInterface;

/**
 * Class DevinotelecomSms.
 *
 * @method static ResponseInterface sendShortMessage(array|string|ShortMessage $receivers, string|null $body = null)
 */
class DevinotelecomSms extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'devinotelecom-sms';
    }
}
