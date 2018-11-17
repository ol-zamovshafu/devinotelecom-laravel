# DevinotelecomSms Notification Channel For Laravel 5.7+

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ol-zamovshafu/devinotelecom-laravel.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/jet-sms)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This package makes it easy to send notifications using [Devinotelecom](https://devinotele.com) with Laravel 5.7.

## Contents

- [Installation](#installation)
    - [Setting up the DevinotelecomSms service](#setting-up-the-devinotelecomSms-service)
- [Usage](#usage)
    - [Available methods](#available-methods)
    - [Available events](#available-events)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install this package via composer:

``` bash
composer require ol-zamovshafu/devinotelecom-laravel
```

Next add the service provider to your `config/app.php`:

```php
/*
 * Package Service Providers...
 */

NotificationChannels\Devinotelecom\DevinotelecomSmsServiceProvider::class,
```

Register the DevinotelecomSms alias to your application.
This registration is not optional because the channel itself uses this very alias.

```php
'DevinotelecomSms' => NotificationChannels\Devinotelecom\DevinotelecomSms::class,
```

### Setting up the DevinotelecomSms service

Add your desired client, login, password, originator (outbox name, sender name) and request timeout
configuration to your `config/services.php` file:
                                                                     
```php
...
    'DevinotelecomSms' => [
        'client'     => 'http',
        'http'       => [
            'endpoint' => 'https://integrationapi.net/rest/',
        ],
        'login'   => '',
        'password'   => '',
        'originator' => '', // Sender name.
        'timeout'    => 60,
    ],
...
```

## Usage

Now you can use the channel in your via() method inside the notification:

```php
use NotificationChannels\Devinotelecom\DevinotelecomSmsChannel;
use Zamovshafu\Devinotelecom\ShortMessage;

class ResetPasswordWasRequested extends Notification
{
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [DevinotelecomSmsChannel::class];
    }
    
    /**
     * Get the DevinotelecomSms representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return string|\Zamovshafu\Devinotelecom\ShortMessage
     */
    public function toJetSms($notifiable) {
        return "Test notification";
        // Or
        return new ShortMessage($notifiable->phone_number, 'Test notification');
    }
}
```

Don't forget to place the dedicated method for DevinotelecomSms inside your notifiables. (e.g. User)

```php
class User extends Authenticatable
{
    use Notifiable;
 
    public function routeNotificationForDevinotelecomSms()
    {
        return "905123456789";
    }
}
```

### Available methods

DevinotelecomSms can also be used directly to send short messages.

Examples:
```php
DevinotelecomSms::sendShortMessage($to, $message);
```

see: [devinotelecom-php](https://github.com/ol-zamovshafu/devinotelecom-php) documentation for more information.

### Available events

JetSms Notification channel comes with handy events which provides the required information about the SMS messages.

1. **Message Was Sent** (`NotificationChannels\Devinotelecom\Events\MessageWasSent`)
3. **Sending Message** (`NotificationChannels\Devinotelecom\Events\SendingMessage`)

Example:

```php
namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Devinotelecom\Events\MessageWasSent;

class SentMessageHandler
{
    /**
     * Handle the event.
     *
     * @param  MessageWasSent  $event
     * @return void
     */
    public function handle(MessageWasSent $event)
    {
        $response = $event->response;
        $message = $event->message;
    }
}
```

### Notes

$response->groupId() will throw BadMethodCallException if the client is set to 'http'. 

Change client configuration with caution.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email oleg.lobanov@zamovshafu.com.ua instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Oleg Lobanov](https://github.com/ol-zamovshafu)
- [All Contributors](../../contributors)

## License

Copyright (c) Hilmi Erdem KEREN erdemkeren@gmail.com

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
