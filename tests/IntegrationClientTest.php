<?php

namespace AppTests;

use App\Client;
use PHPUnit\Framework\TestCase;

final class IntegrationClientTest extends TestCase
{
    public function testClient(): void
    {
        $client = new Client(new \GuzzleHttp\Client());

        $result = $client->grabData(3);

        self::assertCount(3, $result);
        self::assertContains('CR90 corvette', $result);
    }
}
