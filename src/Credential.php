<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp;

use Webmozart\Assert\Assert;

final class Credential
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    public function __construct(string $username, string $password, string $clientId, string $clientSecret)
    {
        $this->username = $username;
        $this->password = $password;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public static function fromArray(array $data): self
    {
        Assert::allStringNotEmpty($data);

        Assert::keyExists($data, 'username');
        Assert::keyExists($data, 'password');
        Assert::keyExists($data, 'client_id');
        Assert::keyExists($data, 'client_secret');

        return new self($data['username'], $data['password'], $data['client_id'], $data['client_secret']);
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    public function toArray(): array
    {
        return [
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
        ];
    }

    public function getOAuthCredential(): array
    {
        return $this->toArray() + [
            'grant_type' => 'password',
        ];
    }
}
