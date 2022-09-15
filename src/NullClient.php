<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp;

use Inisiatif\WhatsappQontakPhp\Message\Message;

final class NullClient implements ClientInterface
{
    public function send(string $templateId, string $channelId, Message $message): Response
    {
        return new Response('messageId', $message->getReceiver()->getName());
    }
}
