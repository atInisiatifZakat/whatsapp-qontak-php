<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Tests;

use PHPUnit\Framework\TestCase;
use Inisiatif\WhatsappQontakPhp\MessageUtil;
use Inisiatif\WhatsappQontakPhp\Message\Body;
use Inisiatif\WhatsappQontakPhp\Message\Button;
use Inisiatif\WhatsappQontakPhp\Message\Header;
use Inisiatif\WhatsappQontakPhp\Message\Message;
use Inisiatif\WhatsappQontakPhp\Message\Language;
use Inisiatif\WhatsappQontakPhp\Message\Receiver;

final class MessageUtilTest extends TestCase
{
    public function test_can_make_request_body(): void
    {
        $receiver = new Receiver('+628000000000', 'Foo bar');
        $language = new Language('id');
        $body = [new Body('Nuradiyana'), new Body('Gorengan')];
        $header = new Header(Header::TYPE_DOCUMENT, 'https://example.com', 'example.pdf');
        $buttons = [new Button('url', 'https://example.com')];

        $message = new Message($receiver, $language, $body, $header, $buttons);

        $params = MessageUtil::makeRequestBody($message);

        $this->assertSame([
            'to_name' => $receiver->getName(),
            'to_number' => $receiver->getTo(),
            'language' => [
                'code' => $language->getCode(),
            ],
            'parameters' => [
                'body' => [
                    [
                        'key' => 1,
                        'value' => 'param1',
                        'value_text' => 'Nuradiyana',
                    ],
                    [
                        'key' => 2,
                        'value' => 'param2',
                        'value_text' => 'Gorengan',
                    ],
                ],
                'buttons' => [
                    [
                        'index' => '0',
                        'type' => 'url',
                        'value' => 'https://example.com',
                    ],
                ],
                'header' => [
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
                ],
            ],
        ], $params);
    }

    public function test_can_make_request_body_without_header(): void
    {
        $receiver = new Receiver('+628000000000', 'Foo bar');
        $language = new Language('id');
        $body = [new Body('Nuradiyana'), new Body('Gorengan')];
        $buttons = [new Button('url', 'https://example.com')];

        $message = new Message($receiver, $language, $body, null, $buttons);

        $params = MessageUtil::makeRequestBody($message);

        $this->assertSame([
            'to_name' => $receiver->getName(),
            'to_number' => $receiver->getTo(),
            'language' => [
                'code' => $language->getCode(),
            ],
            'parameters' => [
                'body' => [
                    [
                        'key' => 1,
                        'value' => 'param1',
                        'value_text' => 'Nuradiyana',
                    ],
                    [
                        'key' => 2,
                        'value' => 'param2',
                        'value_text' => 'Gorengan',
                    ],
                ],
                'buttons' => [
                    [
                        'index' => '0',
                        'type' => 'url',
                        'value' => 'https://example.com',
                    ],
                ],
            ],
        ], $params);
    }

    public function test_can_make_request_body_with_default_message(): void
    {
        $receiver = new Receiver('+628000000000', 'Foo bar');
        $language = new Language('id');

        $message = new Message($receiver, $language);

        $params = MessageUtil::makeRequestBody($message);

        $this->assertSame([
            'to_name' => $receiver->getName(),
            'to_number' => $receiver->getTo(),
            'language' => [
                'code' => $language->getCode(),
            ],
            'parameters' => [
                'body' => [],
                'buttons' => [],
            ],
        ], $params);
    }
}
