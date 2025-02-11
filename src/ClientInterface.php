<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp;

use Inisiatif\WhatsappQontakPhp\Message\Message;

interface ClientInterface
{
    public function send(string $accessToken, string $templateId, string $channelId, Message $message): Response;
}
