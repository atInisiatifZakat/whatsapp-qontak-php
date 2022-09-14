<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Tests;

use PHPUnit\Framework\TestCase;
use Inisiatif\WhatsappQontakPhp\Response;

final class ResponseTest extends TestCase
{
    public function test_create_object_response(): void
    {
        $response = new Response('messageId', 'Foo bar', [
            'id' => 'messageId',
            'name' => 'Foo bar',
        ]);

        $this->assertSame('messageId', $response->getMessageId());
        $this->assertSame('Foo bar', $response->getName());
        $this->assertSame([
            'id' => 'messageId',
            'name' => 'Foo bar',
        ], $response->getData());
    }
}
