<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Tests\Message;

use PHPUnit\Framework\TestCase;
use Inisiatif\WhatsappQontakPhp\Message\Body;

final class BodyTest extends TestCase
{
    public function test_to_array_body(): void
    {
        $body = new Body('Param');

        $this->assertSame([
            'value_text' => 'Param',
        ], $body->toArray());
        $this->assertSame([
            'value_text' => 'Param',
        ], [
            'value_text' => $body->getValue(),
        ]);
    }
}
