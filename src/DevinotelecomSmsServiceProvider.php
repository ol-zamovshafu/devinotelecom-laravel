<?php

namespace NotificationChannels\Devinotelecom;

use GuzzleHttp\Client;
use UnexpectedValueException;
use Zamovshafu\Devinotelecom\Http\Clients;
use Zamovshafu\Devinotelecom\ShortMessage;
use Zamovshafu\Devinotelecom\Service;
use Illuminate\Support\ServiceProvider;
use Zamovshafu\Devinotelecom\ShortMessageFactory;
use Zamovshafu\Devinotelecom\Http\Responses\ResponseInterface;

/**
 * Class DevinotelecomSmsServiceProvider.
 */
class DevinotelecomSmsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->registerDevinotelecomSmsClient();
        $this->registerDevinotelecomSmsService();
    }

    /**
     * Register the DevinotelecomSms Client binding with the container.
     *
     * @return void
     */
    private function registerDevinotelecomSmsClient()
    {
        $this->app->bind(Clients\ClientInterface::class, function () {
            $login = config('services.DevinotelecomSms.login');
            $password = config('services.DevinotelecomSms.password');
            $originator = config('services.DevinotelecomSms.originator');

            switch (config('services.DevinotelecomSms.client', 'http')) {
                case 'http':
                    $timeout = config('services.DevinotelecomSms.timeout');
                    $endpoint = config('services.DevinotelecomSms.http.endpoint');
                    $client = new Clients\HttpClient(
                        new Client(['timeout' => $timeout]),
                        $endpoint,
                        $login,
                        $password,
                        $originator
                    );
                    break;
                default:
                    throw new UnexpectedValueException('Unknown DevinotelecomSms API client has been provided.');
            }

            return $client;
        });
    }

    /**
     * Register the devinotelecom-sms service.
     */
    private function registerDevinotelecomSmsService()
    {
        $beforeSingle = function (ShortMessage $shortMessage) {
            event(new Events\SendingMessage($shortMessage));
        };

        $afterSingle = function (ResponseInterface $response, ShortMessage $shortMessage) {
            event(new Events\MessageWasSent($shortMessage, $response));
        };

        $this->app->singleton('devinotelecom-sms', function ($app) use (
            $beforeSingle,
            $afterSingle
        ) {
            return new Service(
                $app->make(Clients\ClientInterface::class),
                new ShortMessageFactory(),
                $beforeSingle,
                $afterSingle
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'devinotelecom-sms',
            Clients\ClientInterface::class,
        ];
    }
}
