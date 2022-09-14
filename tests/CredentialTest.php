<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Tests;

use PHPUnit\Framework\TestCase;
use Inisiatif\WhatsappQontakPhp\Credential;

final class CredentialTest extends TestCase
{
    public function test_to_array_credential(): void
    {
        $credential = new Credential('username', 'password', 'clientId', 'secret');

        $this->assertSame(
            [
                'username' => 'username',
                'password' => 'password',
                'client_id' => 'clientId',
                'client_secret' => 'secret',
            ],
            $credential->toArray()
        );
    }

    public function test_get_oauth_credential(): void
    {
        $credential = new Credential('username', 'password', 'clientId', 'secret');

        $this->assertSame(
            [
                'username' => 'username',
                'password' => 'password',
                'client_id' => 'clientId',
                'client_secret' => 'secret',
                'grant_type' => 'password',
            ],
            $credential->getOAuthCredential()
        );
    }
}
