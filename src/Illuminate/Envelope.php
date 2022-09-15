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

    public function __construct(string $templateId, string $channelId, Message $message)
    {
        $this->templateId = $templateId;
        $this->channelId = $channelId;
        $this->message = $message;
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
