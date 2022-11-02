<?php

namespace BothelpSDK\Entities\Subscriber;

class Subscriber
{
    private int $id;
    private int $createdAt;
    private bool $subscribed;
    private string $name;
    private string $email;
    private string $phone;
    private string $channelName;
    private string $channelType;
    private string $cuid;
    private string $utmSource;
    private string $utmTerm;
    private string $utmContent;
    private string $utmCampaign;
    private string $utmMedium;
    private array $tags = [];
    private array $rawData = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function isSubscribed(): bool
    {
        return $this->subscribed;
    }

    public function setSubscribed(bool $subscribed): self
    {
        $this->subscribed = $subscribed;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getChannelName(): string
    {
        return $this->channelName;
    }

    public function setChannelName(string $channelName): self
    {
        $this->channelName = $channelName;
        return $this;
    }

    public function getChannelType(): string
    {
        return $this->channelType;
    }

    public function setChannelType(string $channelType): self
    {
        $this->channelType = $channelType;
        return $this;
    }

    public function getCuid(): string
    {
        return $this->cuid;
    }

    public function setCuid(string $cuid): self
    {
        $this->cuid = $cuid;
        return $this;
    }

    public function getUtmSource(): string
    {
        return $this->utmSource;
    }

    public function setUtmSource(string $utmSource): self
    {
        $this->utmSource = $utmSource;
        return $this;
    }

    public function getUtmTerm(): string
    {
        return $this->utmTerm;
    }

    public function setUtmTerm(string $utmTerm): self
    {
        $this->utmTerm = $utmTerm;
        return $this;
    }

    public function getUtmContent(): string
    {
        return $this->utmContent;
    }

    public function setUtmContent(string $utmContent): self
    {
        $this->utmContent = $utmContent;
        return $this;
    }

    public function getUtmCampaign(): string
    {
        return $this->utmCampaign;
    }

    public function setUtmCampaign(string $utmCampaign): self
    {
        $this->utmCampaign = $utmCampaign;
        return $this;
    }

    public function getUtmMedium(): string
    {
        return $this->utmMedium;
    }

    public function setUtmMedium(string $utmMedium): self
    {
        $this->utmMedium = $utmMedium;
        return $this;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function setTags(array $tags): self
    {
        $this->tags = $tags;
        return $this;
    }

    public function getRawData(): array
    {
        return $this->rawData;
    }

    public function setRawData(array $rawData): self
    {
        $this->rawData = $rawData;
        return $this;
    }
}
