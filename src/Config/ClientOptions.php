<?php

namespace BothelpSDK\Config;

use BothelpSDK\Request\Auth\CredentialsRequest;
use Psr\Http\Client\ClientInterface;

class ClientOptions
{
    private string $clientId;
    private string $clientSecret;
    private ?ClientInterface $httpClient = null;
    private ?string $apiUrl = null;

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function setClientId(string $clientId): self
    {
        $this->clientId = $clientId;
        return $this;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    public function setClientSecret(string $clientSecret): self
    {
        $this->clientSecret = $clientSecret;
        return $this;
    }

    public function getHttpClient(): ?ClientInterface
    {
        return $this->httpClient;
    }

    public function setHttpClient(?ClientInterface $httpClient): self
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    public function getApiUrl(): ?string
    {
        return $this->apiUrl;
    }

    public function setApiUrl(?string $apiUrl): self
    {
        $this->apiUrl = $apiUrl;
        return $this;
    }

    public function makeCredentialsRequest(): CredentialsRequest
    {
        return (new CredentialsRequest())
            ->setClientId($this->getClientId())
            ->setClientSecret($this->getClientSecret());
    }
}
