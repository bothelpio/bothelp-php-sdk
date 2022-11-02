<?php

namespace BothelpSDK;

use BothelpSDK\Config\ClientOptions;
use BothelpSDK\Config\Endpoints;
use BothelpSDK\Exception\ApiRequestException;
use BothelpSDK\Exception\ApiResponseException;
use BothelpSDK\Exception\AuthException;
use BothelpSDK\Request\Auth\CredentialsRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Webmozart\Assert\Assert;

class BothelpClient
{
    protected ClientInterface $client;

    protected string $baseUrl = Endpoints::BASE_API_URL . '/' . Endpoints::V1 . '/';

    protected int $defaultHttpTimeout = 10;

    private ?string $token = null;

    public function __construct(ClientOptions $options)
    {
        if ($options && $options->getHttpClient()) {
            $this->setOptions($options);
        } else {
            $this->client = new Client([
                'base_uri' => ($options && $options->getApiUrl()) ? $options->getApiUrl() : $this->baseUrl,
                'timeout' => $this->defaultHttpTimeout
            ]);
        }
        $this->auth($options->makeCredentialsRequest());
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function auth(CredentialsRequest $credentialsRequest): void
    {
        try {
            $response = $this->client->request('POST', Endpoints::AUTH_URL, [
                'headers' => [
                    'User-Agent' => 'BothelpPhpSDK',
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $credentialsRequest->getClientId(),
                    'client_secret' => $credentialsRequest->getClientSecret()
                ]
            ]);
        } catch (GuzzleException $exception) {
            throw new AuthException('Failed api request with error: ' . $exception->getMessage());
        }
        $content = $this->checkAndPrepareResponse($response);
        if (!isset($content['access_token'])) {
            throw new AuthException('Auth failed with error: ' . $response->getBody());
        }

        $this->token = $content['access_token'];
    }

    public function apiRequest(string $method, string $endpoint, ?array $body = [], ?array $exHeaders = []): array
    {
        if (!$this->token) {
            throw new AuthException('Need authorization for request');
        }
        Assert::inArray($method, Endpoints::ALLOWED_METHODS, 'Invalid request method');
        $headers = array_merge($this->getDefaultHeaders(), $exHeaders);
        $request['headers'] = $headers;
        $request['json'] = $body;
        try {
            $response = $this->client->request($method, $endpoint, $request);
        } catch (GuzzleException $e) {
            throw new ApiRequestException('Failed api request with error: ' . $e->getMessage());
        }

        return $this->checkAndPrepareResponse($response);
    }

    protected function setOptions(ClientOptions $options): void
    {
        if ($options->getHttpClient()) {
            $this->client = $options->getHttpClient();
        }
        if ($options->getApiUrl()) {
            $this->baseUrl = $options->getApiUrl();
        }
    }

    protected function getDefaultHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
            'User-Agent' => 'BothelpPhpSDK'
        ];
    }

    protected function checkAndPrepareResponse(ResponseInterface $response): array
    {
        if ($response->getStatusCode() != 200) {
            throw new ApiRequestException(
                'Failed api request with error ' .
                $response->getStatusCode() . ' ' .
                $response->getBody()->getContents()
            );
        }
        try {
            $data = json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $exception) {
            throw new ApiResponseException('Invalid response format');
        }

        return $data;
    }
}
