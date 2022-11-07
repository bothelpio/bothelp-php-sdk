<?php

namespace BothelpSDK\Request\Subscriber;

class SubscriberId
{
    private ?int $id = null;

    private ?string $cuid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getCuid(): ?string
    {
        return $this->cuid;
    }

    public function setCuid(?string $cuid): self
    {
        $this->cuid = $cuid;
        return $this;
    }
}
