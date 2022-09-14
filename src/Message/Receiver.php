<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Message;

final class Receiver
{
    /**
     * @var string
     */
    private $to;

    /**
     * @var string
     */
    private $name;

    public function __construct(string $to, string $name)
    {
        $this->to = $to;
        $this->name = $name;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
