<?php

namespace BothelpSDK\Request\Auth;

class CredentialsRequest
{
    private string $clientId;

    private string $clientSecret;

    public function __construct(?string $clientId = null, ?string $clientSecret = null)
    {
        if ($clientId) {
            $this->setClientId($clientId);
        }
        if ($clientSecret) {
            $this->setClientSecret($clientSecret);
        }
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
}
