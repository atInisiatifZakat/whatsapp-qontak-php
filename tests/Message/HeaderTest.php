<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Tests\Message;

use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;
use Inisiatif\WhatsappQontakPhp\Message\Header;

final class HeaderTest extends TestCase
{
    public function test_to_array_header(): void
    {
        $header = new Header(Header::TYPE_DOCUMENT, 'https://example.com', 'example.pdf');

        $this->assertSame([
            'format' => 'DOCUMENT',
            'params' => [
                [
                    'key' => 'url',
                    'value' => 'https://example.com',
                ],
                [
                    'key' => 'filename',
                    'value' => 'example.pdf',
                ],
            ],
        ], $header->toArray());
    }

    public function test_format_validation(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected one of: "DOCUMENT", "VIDEO", "IMAGE". Got: "INVALID TYPE"');

        new Header('INVALID TYPE', 'https://example.com', 'example.pdf');
    }
}
