<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Message;

use Webmozart\Assert\Assert;

final class Message
{
    /**
     * @var Receiver
     */
    private $receiver;

    /**
     * @var Language
     */
    private $language;

    /**
     * @var Header|null
     */
    private $header;

    /**
     * @var Body[]
     */
    private $body;

    /**
     * @var Button[]
     */
    private $buttons;

    public function __construct(Receiver $receiver, ?Language $language = null, array $body = [], ?Header $header = null, array $buttons = [])
    {
        $this->receiver = $receiver;

        $this->language = $language ?? new Language('id');

        $this->header = $header;

        Assert::allIsInstanceOf($body, Body::class);
        $this->body = $body;

        Assert::allIsInstanceOf($buttons, Button::class);
        $this->buttons = $buttons;
    }

    public function getReceiver(): Receiver
    {
        return $this->receiver;
    }

    public function getLanguage(): Language
    {
        return $this->language;
    }

    public function getHeader(): ?Header
    {
        return $this->header;
    }

    /**
     * @return Body[]
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * @return Button[]
     */
    public function getButtons(): array
    {
        return $this->buttons;
    }
}
