<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Illuminate;

use Inisiatif\WhatsappQontakPhp\ClientInterface;
use Inisiatif\WhatsappQontakPhp\Exceptions\ClientSendingException;

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

        try {
            $this->client->send(
                $envelope->getTemplateId(),
                $envelope->getChannelId(),
                $envelope->getMessage()
            );
        } catch (ClientSendingException $e) {
            if ($e->getCode() === 429) {
                if (property_exists($notification, 'job') && $notification->job !== null) {
                    $delay = 0;

                    if ($notification instanceof QontakShouldDelay) {
                        $delay = $notification->getReleaseDelay();
                    }

                    // get delay from rate_limit_reset
                    $errorResponse = json_decode($e->getMessage(), true);

                    if (isset($errorResponse['error']['messages'])) {
                        foreach ($errorResponse['error']['messages'] as $message) {
                            if (strpos($message, 'rate_limit_reset:') === 0) {
                                $delay = (int) trim(str_replace('rate_limit_reset:', '', $message));
                                break;
                            }
                        }
                    }

                    $notification->job->release($delay);
                    return;
                }
            }

            throw $e;
        }
    }
}
