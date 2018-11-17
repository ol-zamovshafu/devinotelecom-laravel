<?php

namespace NotificationChannels\Devinotelecom;

use Zamovshafu\Devinotelecom\ShortMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Devinotelecom\Exceptions\CouldNotSendNotification;

/**
 * Class DevinotelecomSmsChannel.
 */
final class DevinotelecomSmsChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed                                  $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @throws \NotificationChannels\Devinotelecom\Exceptions\CouldNotSendNotification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toDevinotelecomSms($notifiable);

        if ($message instanceof ShortMessage) {
            DevinotelecomSms::sendShortMessage($message);

            return;
        }

        $to = $notifiable->routeNotificationFor('DevinotelecomSms');

        if (empty($to)) {
            throw CouldNotSendNotification::missingRecipient();
        }

        DevinotelecomSms::sendShortMessage($to, $message);
    }
}
