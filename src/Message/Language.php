<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Message;

use Webmozart\Assert\Assert;

final class Language
{
    /**
     * @var string
     */
    private $code;

    public function __construct(string $code)
    {
        Assert::length($code, 2);
        Assert::inArray($code, ['id', 'en']);

        $this->code = $code;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
