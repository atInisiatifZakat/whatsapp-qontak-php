<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp;

use Psr\Http\Client\ClientInterface as HttpClient;

final class ClientFactory
{
    /**
     * @var Client|null
     */
    private static $client = null;

    /**
     * @var NullClient|null
     */
    private static $nullClient = null;

    public static function makeFromArray(array $config, HttpClient $httpClient = null): ClientInterface
    {
        if (! self::$client instanceof Client) {
            self::$client = new Client(
                Credential::fromArray($config),
                $httpClient
            );
        }

        return self::$client;
    }

    public static function makeTestingClient(): ClientInterface
    {
        if (! self::$nullClient instanceof NullClient) {
            self::$nullClient = new NullClient();
        }

        return self::$nullClient;
    }
}
