<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Tests\Message;

use PHPUnit\Framework\TestCase;
use Inisiatif\WhatsappQontakPhp\Message\Receiver;

final class ReceiverTest extends TestCase
{
    public function test_create_object_receiver(): void
    {
        $receiver = new Receiver('+628000000000', 'Foo bar');

        $this->assertSame('+628000000000', $receiver->getTo());
        $this->assertSame('Foo bar', $receiver->getName());
    }
}
