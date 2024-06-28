<?php

declare(strict_types=1);

namespace App\Domain;

use App\Enum\Permission;
use Webmozart\Assert\Assert;

final class Token
{
    /**
     * @param string $token
     * @param array<Permission> $permissions
     */
    private function __construct(public readonly string $token, public readonly array $permissions)
    {
    }

    /**
     * @param array{token: string, permissions: string[]} $tokenData
     */
    public static function fromTokenData(array $tokenData): self
    {
        Assert::keyExists($tokenData, 'token');
        Assert::keyExists($tokenData, 'permissions');

        $permissions = [];

        foreach ($tokenData['permissions'] as $permission) {
            $permissions[] = Permission::fromString($permission);
        }

        return new self($tokenData['token'], $permissions);
    }

    public static function fromString(string $token): self
    {
        return new self($token, []);
    }

    public function equals(Token $token): bool
    {
        return $this->token === $token->token;
    }

    public function notEquals(Token $token): bool
    {
        return !$this->equals($token);
    }

    public function hasPermission(Permission $permission): bool
    {
        return in_array($permission, $this->permissions, true);
    }
}
