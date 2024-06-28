<?php

declare(strict_types=1);

namespace App\Handler;

use App\Enum\Permission;
use App\Evaluator\PermissionEvaluator;
use App\Provider\TokenObjectProvider;
use ProgPhil1337\SimpleReactApp\HTTP\Response\JSONResponse;
use ProgPhil1337\SimpleReactApp\HTTP\Response\ResponseInterface;
use ProgPhil1337\SimpleReactApp\HTTP\Routing\Attribute\Route;
use ProgPhil1337\SimpleReactApp\HTTP\Routing\Handler\HandlerInterface;
use ProgPhil1337\SimpleReactApp\HTTP\Routing\HttpMethod;
use ProgPhil1337\SimpleReactApp\HTTP\Routing\RouteParameters;
use Psr\Http\Message\ServerRequestInterface;
use Webmozart\Assert\Assert;

#[Route(httpMethod: HttpMethod::GET, uri: '/has_permission/{token}')]
class PermissionHandler implements HandlerInterface
{
    /**
     * Dependency Injection would be available here
     */
    public function __construct(private readonly TokenObjectProvider $tokenObjectProvider, private readonly PermissionEvaluator $permissionEvaluator)
    {
    }

    public function __invoke(ServerRequestInterface $serverRequest, RouteParameters $parameters): ResponseInterface
    {
        try {
            $token = $parameters->get('token');
            Assert::string($token);
            $givenToken    = $this->tokenObjectProvider->getTokenByString($token);
            $hasPermission = $this->permissionEvaluator->hasPermission($givenToken, Permission::READ);
        } catch (\InvalidArgumentException $e) {
            $hasPermission = false;
        }

        return new JSONResponse(['permission' => $hasPermission], $hasPermission ? 200 : 403);
    }
}
