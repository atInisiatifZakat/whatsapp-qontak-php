<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Tests\Message;

use PHPUnit\Framework\TestCase;
use Inisiatif\WhatsappQontakPhp\Message\Button;

final class ButtonTest extends TestCase
{
    public function test_to_array_button(): void
    {
        $button = new Button('url', 'https://example.com');

        $this->assertSame(
            [
                'type' => 'url',
                'value' => 'https://example.com',
            ],
            $button->toArray()
        );

        $this->assertSame(
            [
                'type' => 'url',
                'value' => 'https://example.com',
            ],
            [
                'type' => $button->getType(),
                'value' => $button->getValue(),
            ]
        );
    }
}
