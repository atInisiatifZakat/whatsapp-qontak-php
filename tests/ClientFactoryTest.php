<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Tests;

use Mockery;
use PHPUnit\Framework\TestCase;
use Inisiatif\WhatsappQontakPhp\Client;
use Inisiatif\WhatsappQontakPhp\NullClient;
use Inisiatif\WhatsappQontakPhp\ClientFactory;
use Http\Client\Common\HttpMethodsClientInterface;

final class ClientFactoryTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_can_create_client(): void
    {
        $config = [
            'username' => 'username',
            'password' => 'password',
            'client_id' => 'clientId',
            'client_secret' => 'secret',
        ];

        $httpClient = Mockery::mock(HttpMethodsClientInterface::class)->makePartial();

        $client = ClientFactory::makeFromArray($config, $httpClient);
        $this->assertInstanceOf(Client::class, $client);

        $client = ClientFactory::makeTestingClient();
        $this->assertInstanceOf(NullClient::class, $client);
    }

    public function test_create_same_object_in_multiple_creation(): void
    {
        $config = [
            'username' => 'username',
            'password' => 'password',
            'client_id' => 'clientId',
            'client_secret' => 'secret',
        ];

        $httpClient = Mockery::mock(HttpMethodsClientInterface::class)->makePartial();

        $client1 = ClientFactory::makeFromArray($config, $httpClient);
        $this->assertInstanceOf(Client::class, $client1);

        $client2 = ClientFactory::makeFromArray($config, $httpClient);
        $this->assertSame($client1, $client2);
    }
}
