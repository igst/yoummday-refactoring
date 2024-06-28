<?php

declare(strict_types=1);

namespace Test\Handler;

use App\Domain\Token;
use App\Enum\Permission;
use PHPUnit\Framework\TestCase;
use Test\SetupTrait;

class PermissionEvaluatorTest extends TestCase
{
    use SetupTrait;

    /**
     * @return array<array{string, bool, bool}>
     */
    public static function tokenProvider(): array
    {
        return [
            ['token1234', true, false],
            ['tokenReadonly', true, false],
            ['tokenNoPermission', false, true],
        ];
    }

    /**
     * @dataProvider tokenProvider
     */
    public function testReadPermissionGrantedIfTokenExistsAndHasPermission(string $tokenString, bool $expectedPermission, bool $expectException): void
    {
        if ($expectException) {
            $this->expectException(\InvalidArgumentException::class);
        }

        $token = $this->getTokenObjectProvider()->getTokenByString($tokenString);

        if (!$expectException) {
            $hasPermission = $this->getPermissionEvaluator()->hasPermission($token, Permission::READ);
            $this->assertSame($expectedPermission, $hasPermission);
        }
    }

    public function testReadPermissionDeniedWithUnknownToken(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->getTokenObjectProvider()->getTokenByString('hans');
    }

    public function testWritePermissionGranted(): void
    {
        $token         = Token::fromTokenData(['token' => 'token1234', 'permissions' => ['write']]);
        $hasPermission = $this->getPermissionEvaluator()->hasPermission($token, Permission::WRITE);

        $this->assertTrue($hasPermission);
    }

    public function testWritePermissionDenied(): void
    {
        $token         = $this->getTokenObjectProvider()->getTokenByString('tokenReadonly');
        $hasPermission = $this->getPermissionEvaluator()->hasPermission($token, Permission::WRITE);

        $this->assertFalse($hasPermission);
    }
}
