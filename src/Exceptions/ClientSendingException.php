<?php

namespace Inisiatif\WhatsappQontakPhp\Exceptions;

use Exception;
use Psr\Http\Message\ResponseInterface;

final class ClientSendingException extends Exception
{
    public static function make(ResponseInterface $response): self
    {
        $reason = (string) $response->getBody();

        $code = $response->getStatusCode();

        return new self($reason, $code);
    }
}
