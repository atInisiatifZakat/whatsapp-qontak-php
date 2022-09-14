<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Tests\Message;

use PHPUnit\Framework\TestCase;
use Inisiatif\WhatsappQontakPhp\Message\Body;
use Inisiatif\WhatsappQontakPhp\Message\Button;
use Inisiatif\WhatsappQontakPhp\Message\Header;
use Inisiatif\WhatsappQontakPhp\Message\Message;
use Inisiatif\WhatsappQontakPhp\Message\Language;
use Inisiatif\WhatsappQontakPhp\Message\Receiver;

final class MessageTest extends TestCase
{
    public function test_can_create_message_with_default_value(): void
    {
        $receiver = new Receiver('+628000000000', 'Foo bar');

        $message = new Message($receiver);

        $this->assertSame($receiver, $message->getReceiver());
        $this->assertSame($receiver->getTo(), $message->getReceiver()->getTo());
        $this->assertSame($receiver->getName(), $message->getReceiver()->getName());

        $this->assertSame('id', $message->getLanguage()->getCode());

        $this->assertNull($message->getHeader());

        $this->assertSame([], $message->getBody());
        $this->assertSame([], $message->getButtons());
    }

    public function test_can_create_message_with_custom_language(): void
    {
        $receiver = new Receiver('+628000000000', 'Foo bar');
        $language = new Language('id');

        $message = new Message($receiver, $language);

        $this->assertSame($language, $message->getLanguage());
        $this->assertSame($language->getCode(), $message->getLanguage()->getCode());
    }

    public function test_can_create_message_with_body(): void
    {
        $body = [new Body('Nuradiyana'), new Body('Gorengan')];

        $message = new Message(
            new Receiver('+628000000000', 'Foo bar'),
            new Language('id'),
            $body
        );

        $this->assertSame($body, $message->getBody());
        $this->assertSame($body[0]->getValue(), $message->getBody()[0]->getValue());
        $this->assertSame($body[1]->getValue(), $message->getBody()[1]->getValue());
    }

    public function test_can_create_message_with_header(): void
    {
        $header = new Header(Header::TYPE_DOCUMENT, 'https://example.com', 'example.pdf');

        $message = new Message(
            new Receiver('+628000000000', 'Foo bar'),
            new Language('id'),
            [],
            $header
        );

        $this->assertSame($header, $message->getHeader());
        $this->assertSame($header->getUrl(), $message->getHeader()->getUrl());
        $this->assertSame($header->getFilename(), $message->getHeader()->getFilename());
    }

    public function test_can_create_message_with_button(): void
    {
        $buttons = [
            new Button('url', 'https://example.com'),
        ];

        $message = new Message(
            new Receiver('+628000000000', 'Foo bar'),
            new Language('id'),
            [],
            null,
            $buttons
        );

        $this->assertSame($buttons, $message->getButtons());
        $this->assertSame($buttons[0]->getType(), $message->getButtons()[0]->getType());
        $this->assertSame($buttons[0]->getValue(), $message->getButtons()[0]->getValue());
    }
}
