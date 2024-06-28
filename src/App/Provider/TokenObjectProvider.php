<?php

declare(strict_types=1);

namespace App\Provider;

use App\Domain\Token;

final class TokenObjectProvider
{
    public function __construct(private readonly TokenDataProvider $tokenDataProvider)
    {
    }

    /**
     * @return list<Token>
     */
    public function getTokens(): array
    {
        $tokens = [];

        foreach ($this->tokenDataProvider->getTokens() as $tokenData) {
            $tokens[] = Token::fromTokenData($tokenData);
        }

        return  $tokens;
    }

    public function getTokenByString(string $requiredToken): Token
    {
        foreach ($this->getTokens() as $token) {
            if ($requiredToken === $token->token) {
                return $token;
            }
        }

        throw new \InvalidArgumentException(sprintf('Token "%s" does not exist.', $requiredToken));
    }
}
