<?php

namespace App;

final class Client {
    private const BASE_URL = 'https://www.swapi.tech/api/starships';

    public function __construct(private \GuzzleHttp\Client $client)
    {
    }

    public function grabData(int $size = 1): array
    {
        $data = $this->makeRequest(self::BASE_URL);
        $results = [];

        for ($i = 0; $i < $size; $i++) {
            $detailData = $this->makeRequest($data['results'][$i]['url']);
            $results[] = $detailData['result']['properties']['model'];
        }

        return $results;
    }

    private function makeRequest(string $url): array
    {
        return json_decode($this->client
            ->get($url)
            ->getBody()
            ->getContents(), true);
    }
}
