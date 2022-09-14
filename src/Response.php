<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp;

final class Response
{
    /**
     * @var string|null
     */
    private $messageId;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var array
     */
    private $data;

    public function __construct(string $messageId = null, string $name = null, array $data = [])
    {
        $this->messageId = $messageId;
        $this->name = $name;
        $this->data = $data;
    }

    public function getMessageId(): ?string
    {
        return $this->messageId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
