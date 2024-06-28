<?php

declare(strict_types=1);

namespace Test;

use App\Evaluator\PermissionEvaluator;
use App\Provider\TokenObjectProvider;
use Progphil1337\Config\Config;
use ProgPhil1337\DependencyInjection\ClassLookup;
use ProgPhil1337\DependencyInjection\Injector;
use Webmozart\Assert\Assert;

trait SetupTrait
{
    protected ?Injector $injector;
    protected ?TokenObjectProvider $tokenObjectProvider;
    protected ?PermissionEvaluator $permissionEvaluator;

    protected function getPermissionEvaluator(): PermissionEvaluator
    {
        if (isset($this->permissionEvaluator)) {
            return $this->permissionEvaluator;
        }

        $permissionEvaluator = $this->getInjector()->create(PermissionEvaluator::class);
        Assert::isInstanceOf($permissionEvaluator, PermissionEvaluator::class);
        $this->permissionEvaluator = $permissionEvaluator;

        return $this->permissionEvaluator;
    }

    protected function getTokenObjectProvider(): TokenObjectProvider
    {
        if (isset($this->tokenObjectProvider)) {
            return $this->tokenObjectProvider;
        }

        $tokenObjectProvider = $this->getInjector()->create(TokenObjectProvider::class);
        Assert::isInstanceOf($tokenObjectProvider, TokenObjectProvider::class);
        $this->tokenObjectProvider = $tokenObjectProvider;

        return $this->tokenObjectProvider;
    }

    protected function getInjector(): Injector
    {
        if (isset($this->injector)) {
            return $this->injector;
        }

        $config = Config::create(__DIR__ . '/../src/config.json');

        $classLookup = (new ClassLookup())
            ->singleton($config)
            ->singleton(Injector::class)
            ->register($config);

        $this->injector = new Injector($classLookup);

        return $this->injector;
    }
}
