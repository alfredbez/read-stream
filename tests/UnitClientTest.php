<?php

namespace AppTests;

use App\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class UnitClientTest extends TestCase
{
    public function testClient(): void
    {
        $stubbedResponseList = new Response(body: '{"message":"ok","total_records":36,"total_pages":4,"previous":null,"next":"https://www.swapi.tech/api/starships?page=2&limit=10","results":[{"uid":"2","name":"CR90 corvette","url":"https://www.swapi.tech/api/starships/2"},{"uid":"3","name":"Star Destroyer","url":"https://www.swapi.tech/api/starships/3"},{"uid":"5","name":"Sentinel-class landing craft","url":"https://www.swapi.tech/api/starships/5"},{"uid":"9","name":"Death Star","url":"https://www.swapi.tech/api/starships/9"},{"uid":"11","name":"Y-wing","url":"https://www.swapi.tech/api/starships/11"},{"uid":"10","name":"Millennium Falcon","url":"https://www.swapi.tech/api/starships/10"},{"uid":"13","name":"TIE Advanced x1","url":"https://www.swapi.tech/api/starships/13"},{"uid":"15","name":"Executor","url":"https://www.swapi.tech/api/starships/15"},{"uid":"12","name":"X-wing","url":"https://www.swapi.tech/api/starships/12"},{"uid":"17","name":"Rebel transport","url":"https://www.swapi.tech/api/starships/17"}]}');
        $stubbedResponseDetail = new Response(body: '{"message":"ok","result":{"properties":{"model":"CR90 corvette","starship_class":"corvette","manufacturer":"Corellian Engineering Corporation","cost_in_credits":"3500000","length":"150","crew":"30-165","passengers":"600","max_atmosphering_speed":"950","hyperdrive_rating":"2.0","MGLT":"60","cargo_capacity":"3000000","consumables":"1 year","pilots":[],"created":"2020-09-17T17:55:06.604Z","edited":"2020-09-17T17:55:06.604Z","name":"CR90 corvette","url":"https://www.swapi.tech/api/starships/2"},"description":"A Starship","_id":"5f63a34fee9fd7000499be1e","uid":"2","__v":0}}');
        $stubbedClient = $this->createStub(\GuzzleHttp\Client::class);
        $stubbedClient->method('get')
            ->willReturnOnConsecutiveCalls(
                $stubbedResponseList,
                $stubbedResponseDetail,
            );
        $client = new Client($stubbedClient);

        $result = $client->grabData();

        self::assertCount(1, $result);
        self::assertContains('CR90 corvette', $result);
    }

    public function testClientWithMultipleRequests(): void
    {
        $stubbedResponseList = new Response(body: '{"message":"ok","total_records":36,"total_pages":4,"previous":null,"next":"https://www.swapi.tech/api/starships?page=2&limit=10","results":[{"uid":"2","name":"CR90 corvette","url":"https://www.swapi.tech/api/starships/2"},{"uid":"3","name":"Star Destroyer","url":"https://www.swapi.tech/api/starships/3"},{"uid":"5","name":"Sentinel-class landing craft","url":"https://www.swapi.tech/api/starships/5"},{"uid":"9","name":"Death Star","url":"https://www.swapi.tech/api/starships/9"},{"uid":"11","name":"Y-wing","url":"https://www.swapi.tech/api/starships/11"},{"uid":"10","name":"Millennium Falcon","url":"https://www.swapi.tech/api/starships/10"},{"uid":"13","name":"TIE Advanced x1","url":"https://www.swapi.tech/api/starships/13"},{"uid":"15","name":"Executor","url":"https://www.swapi.tech/api/starships/15"},{"uid":"12","name":"X-wing","url":"https://www.swapi.tech/api/starships/12"},{"uid":"17","name":"Rebel transport","url":"https://www.swapi.tech/api/starships/17"}]}');
        $stubbedResponseDetail = new Response(body: '{"message":"ok","result":{"properties":{"model":"CR90 corvette","starship_class":"corvette","manufacturer":"Corellian Engineering Corporation","cost_in_credits":"3500000","length":"150","crew":"30-165","passengers":"600","max_atmosphering_speed":"950","hyperdrive_rating":"2.0","MGLT":"60","cargo_capacity":"3000000","consumables":"1 year","pilots":[],"created":"2020-09-17T17:55:06.604Z","edited":"2020-09-17T17:55:06.604Z","name":"CR90 corvette","url":"https://www.swapi.tech/api/starships/2"},"description":"A Starship","_id":"5f63a34fee9fd7000499be1e","uid":"2","__v":0}}');
        $stubbedClient = $this->createStub(\GuzzleHttp\Client::class);
        $stubbedClient->method('get')
            ->willReturnOnConsecutiveCalls(
                $stubbedResponseList,
                $stubbedResponseDetail,
                $stubbedResponseDetail,
                $stubbedResponseDetail,
            );
        $client = new Client($stubbedClient);

        $result = $client->grabData(3);

        self::assertCount(3, $result);
        self::assertContains('CR90 corvette', $result);
    }
}
