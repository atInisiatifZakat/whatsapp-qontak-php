<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Tests\Message;

use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;
use Inisiatif\WhatsappQontakPhp\Message\Language;

final class LanguageTest extends TestCase
{
    public function test_length_validation(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectErrorMessage('Expected a value to contain 2 characters. Got: "foo"');

        new Language('foo');
    }

    public function test_value_validation(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectErrorMessage('Expected one of: "id", "en". Got: "de"');

        new Language('de');
    }
}
