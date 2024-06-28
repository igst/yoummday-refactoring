<?php

declare(strict_types=1);

namespace App\Evaluator;

use App\Domain\Token;
use App\Enum\Permission;
use App\Provider\TokenObjectProvider;

final class PermissionEvaluator
{
    public function __construct(private readonly TokenObjectProvider $tokenObjectProvider)
    {
    }

    public function hasPermission(Token $tokenToBeChecked, Permission $permission): bool
    {
        foreach ($this->tokenObjectProvider->getTokens() as $token) {
            if ($tokenToBeChecked->notEquals($token)) {
                continue;
            }

            if ($tokenToBeChecked->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }
}
