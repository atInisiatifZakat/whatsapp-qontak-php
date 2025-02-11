<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Illuminate;

use Inisiatif\WhatsappQontakPhp\ClientInterface;

final class QontakChannel
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param mixed $notifiable
     */
    public function send($notifiable, QontakNotification $notification): void
    {
        $envelope = $notification->toQontak($notifiable);

        $this->client->send(
            $envelope->getAccessToken(),
            $envelope->getTemplateId(),
            $envelope->getChannelId(),
            $envelope->getMessage()
        );
    }
}
