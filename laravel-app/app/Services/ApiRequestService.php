<?php


namespace App\Services;


use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ApiRequestService
{

    private string $endpoint;
    private string $apikey;
    private PendingRequest $client;

    public function __construct()
    {
        $this->endpoint = config('currency.base');
        $this->apikey = config('currency.apikey');
        $this->client = Http::withHeaders($this->getHeaders());
    }

    /**
     * @param string $path
     * @param array $params
     * @return Response
     */
    public function get(string $path, array $params = []): Response
    {
        return $this->client->get(sprintf('%s%s', $this->endpoint, $path), $params);
    }

    /**
     * @param string $path
     * @param array $params
     * @return Response
     */
    public function post(string $path, array $params = []): Response
    {
        return $this->client->post(sprintf('%s%s', $this->endpoint, $path), $params);
    }

    /**
     * @return array
     */
    private function getHeaders(): array
    {
        return [
            'apikey' => $this->apikey
        ];
    }

}
