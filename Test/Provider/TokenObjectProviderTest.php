<?php

declare(strict_types=1);

namespace Test\Provider;

use App\Domain\Token;
use PHPUnit\Framework\TestCase;
use Test\SetupTrait;

class TokenObjectProviderTest extends TestCase
{
    use SetupTrait;

    public function testGetTokens(): void
    {
        $this->assertEquals(
            [
                Token::fromTokenData(['token' => 'token1234', 'permissions' => ['read', 'write']]),
                Token::fromTokenData(['token' => 'tokenReadonly', 'permissions' => ['read']]),
            ],
            $this->getTokenObjectProvider()->getTokens()
        );
    }
}
