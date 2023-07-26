<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Tests;

use Inisiatif\WhatsappQontakPhp\Exceptions\ClientSendingException;
use Mockery;
use PHPUnit\Framework\TestCase;
use Nyholm\Psr7\Factory\Psr17Factory;
use Inisiatif\WhatsappQontakPhp\Client;
use Psr\Http\Message\ResponseInterface;
use Inisiatif\WhatsappQontakPhp\Credential;
use Inisiatif\WhatsappQontakPhp\Message\Message;
use Inisiatif\WhatsappQontakPhp\Message\Receiver;
use Http\Client\Common\HttpMethodsClientInterface;

final class ClientTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_send_message(): void
    {
        $credential = new Credential('username', 'password', 'clientId', 'secret');

        $receiver = new Receiver('+628000000000', 'Foo bar');
        $message = new Message($receiver);

        $mResponse = Mockery::mock(ResponseInterface::class);
        $mResponse->expects('getBody')->andReturn(
            (new Psr17Factory())->createStream('{"access_token":"access-token","token_type":"bearer","expires_in":31556952,"refresh_token":"refresh-token","created_at":1663138844}')
        );
        $mResponse->expects('getStatusCode')->andReturn(200)->twice();
        $mResponse->expects('getBody')->andReturn(
            (new Psr17Factory())->createStream('{"status": "success", "data": { "id": "dataId", "name": "Foo Bar"}}')
        );

        $httpClient = Mockery::mock(HttpMethodsClientInterface::class)->makePartial();
        $httpClient->expects('post')->andReturn($mResponse)->twice();

        $client = new Client($credential, $httpClient);
        $response = $client->send('templateId', 'channelId', $message);

        $this->assertSame('Foo Bar', $response->getName());
        $this->assertSame('dataId', $response->getMessageId());
        $this->assertSame(\json_decode('{ "id": "dataId", "name": "Foo Bar"}', true), $response->getData());
    }

    public function test_throw_exception_when_sending_message(): void
    {
        $this->expectException(ClientSendingException::class);

        $credential = new Credential('username', 'password', 'clientId', 'secret');

        $receiver = new Receiver('+628000000000', 'Foo bar');
        $message = new Message($receiver);

        $mResponse = Mockery::mock(ResponseInterface::class);
        $mResponse->expects('getBody')->andReturn(
            (new Psr17Factory())->createStream('{"access_token":"access-token","token_type":"bearer","expires_in":31556952,"refresh_token":"refresh-token","created_at":1663138844}')
        );
        $mResponse->expects('getStatusCode')->andReturn(422)->times(3);
        $mResponse->expects('getBody')->andReturn(
            (new Psr17Factory())->createStream('{"status":"error","error":{"code":422,"messages":["Message Template has 4 variable, please adjust your payload."]}} ')
        );

        $httpClient = Mockery::mock(HttpMethodsClientInterface::class)->makePartial();
        $httpClient->expects('post')->andReturn($mResponse)->twice();

        $client = new Client($credential, $httpClient);
        $client->send('templateId', 'channelId', $message);
    }
}
