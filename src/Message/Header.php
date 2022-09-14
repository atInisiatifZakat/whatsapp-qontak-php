<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Message;

use Webmozart\Assert\Assert;

final class Header
{
    public const TYPE_DOCUMENT = 'DOCUMENT';

    public const TYPE_VIDEO = 'VIDEO';

    public const TYPE_IMAGE = 'IMAGE';

    /**
     * @var string
     */
    private $format;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $filename;

    public function __construct(string $format, string $url, string $filename)
    {
        Assert::inArray($format, ['DOCUMENT', 'VIDEO', 'IMAGE']);
        $this->format = $format;

        $this->url = $url;

        $this->filename = $filename;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function toArray(): array
    {
        return [
            'format' => $this->getFormat(),
            'params' => [
                [
                    'key' => 'url',
                    'value' => $this->getUrl(),
                ],
                [
                    'key' => 'filename',
                    'value' => $this->getFilename(),
                ],
            ],
        ];
    }
}
