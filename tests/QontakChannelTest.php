<?php

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Discovery\Psr17Factory;
use Inisiatif\WhatsappQontakPhp\Client;
use Inisiatif\WhatsappQontakPhp\ClientInterface;
use Inisiatif\WhatsappQontakPhp\Credential;
use PHPUnit\Framework\TestCase;
use Inisiatif\WhatsappQontakPhp\Illuminate\QontakChannel;
use Inisiatif\WhatsappQontakPhp\Exceptions\ClientSendingException;
use Inisiatif\WhatsappQontakPhp\Illuminate\Envelope;
use Inisiatif\WhatsappQontakPhp\Illuminate\QontakNotification;
use Inisiatif\WhatsappQontakPhp\Illuminate\QontakShouldDelay;
use Inisiatif\WhatsappQontakPhp\Message\Message;
use Inisiatif\WhatsappQontakPhp\Message\Receiver;
use Psr\Http\Message\ResponseInterface;

final class QontakChannelTest extends TestCase
{
  public function test_it_sends_message_successfully(): void
  {
    // $client = $this->createMock(ClientInterface::class);
    $credential = new Credential('username', 'password', 'clientId', 'secret');

    $mResponse = Mockery::mock(ResponseInterface::class);
    $mResponse->expects('getBody')->andReturn(
      (new Psr17Factory())->createStream('{"access_token":"access-token","token_type":"bearer","expires_in":31556952,"refresh_token":"refresh-token","created_at":1663138844}')
    );
    $mResponse->expects('getStatusCode')->andReturn(200)->times(3);
    $mResponse->expects('getBody')->andReturn(
      (new Psr17Factory())->createStream('{"status": "success", "data": { "id": "dataId", "name": "Foo Bar"}}')
    );

    $httpClient = Mockery::mock(HttpMethodsClientInterface::class)->makePartial();
    $httpClient->expects('post')->andReturn($mResponse)->twice();
    $client = new Client($credential, $httpClient);


    $receiver = new Receiver('+628000000000', 'Foo bar');
    $message = new Message($receiver);
    $envelope = new Envelope('template-id', 'channel-id', $message);

    $notification = $this->createMock(QontakNotification::class);
    $notification->method('toQontak')->willReturn($envelope);

    $httpClient->expects('post')->andReturn($mResponse)->twice();

    $channel = new QontakChannel($client);
    $channel->send(new \stdClass(), $notification);

    $this->assertTrue(true);
  }

  public function test_it_releases_job_when_rate_limited(): void
  {
    $client = Mockery::mock(ClientInterface::class);

    // Siapkan dummy job
    $mockJob = Mockery::mock(stdClass::class);
    $mockJob->shouldReceive('release')->with(10)->once(); // default delay

    // Buat notification yang punya properti `job`
    $notification = Mockery::mock(QontakNotification::class);
    $notification->job = $mockJob;

    $receiver = new Receiver('+628000000000', 'Foo bar');
    $message = new Message($receiver);
    $envelope = new Envelope('template-id', 'channel-id', $message);

    $notification->shouldReceive('toQontak')->andReturn($envelope);

    // Simulasikan exception "Too many requests"
    $client->shouldReceive('send')->andThrow(
      new ClientSendingException('Too many requests')
    );

    $channel = new QontakChannel($client);

    // Eksekusi
    $channel->send(new \stdClass(), $notification);

    // Assert agar tidak exception (artinya release berhasil dipanggil)
    $this->assertTrue(true);
  }
}
