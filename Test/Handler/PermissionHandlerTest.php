<?php

declare(strict_types=1);

namespace Test\Handler;

use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class PermissionHandlerTest extends TestCase
{
    private Client $client;

    protected function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => '127.0.0.1:1337',
        ]);
    }

    public function testPermissionGranted(): void
    {
        $url      = '/has_permission/token1234';
        $response = $this->client->get($url);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertTrue(
            $response->hasHeader('Content-Type') && strpos($response->getHeaderLine('Content-Type'), 'application/json') !== false,
        );

        $responseData = json_decode($response->getBody()->getContents(), true);

        $expectedObject = ['permission' => true];

        $this->assertEquals($expectedObject, $responseData);
    }

    public function testPermissionDenied(): void
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(403);

        $url      = '/has_permission/hans';
        $response = $this->client->get($url);

        $this->assertEquals(403, $response->getStatusCode());

        $this->assertTrue(
            $response->hasHeader('Content-Type') && strpos($response->getHeaderLine('Content-Type'), 'application/json') !== false,
        );

        $responseData = json_decode($response->getBody()->getContents(), true);

        $expectedObject = ['permission' => false];

        $this->assertEquals($expectedObject, $responseData);
    }
}
