<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Illuminate;

use Inisiatif\WhatsappQontakPhp\Message\Message;

final class Envelope
{
    /**
     * @var string
     */
    private $templateId;

    /**
     * @var string
     */
    private $channelId;

    /**
     * @var Message
     */
    private $message;

    /**
     * @var string|null
     */
    private $accessToken;

    public function __construct(?string $accessToken, string $templateId, string $channelId, Message $message)
    {
        $this->accessToken = $accessToken;
        $this->templateId = $templateId;
        $this->channelId = $channelId;
        $this->message = $message;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function getTemplateId(): string
    {
        return $this->templateId;
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }
}
