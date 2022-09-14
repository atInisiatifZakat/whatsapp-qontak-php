<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Message;

final class Body
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return [
            'value_text' => $this->getValue(),
        ];
    }
}
