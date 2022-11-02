<?php

namespace BothelpSDK\Request\Subscriber;

class SubscriberFilter
{
    private ?int $createdAfter = null;
    private ?string $afterId = null;
    private ?string $email = null;

    public function getCreatedAfter(): ?int
    {
        return $this->createdAfter;
    }

    public function setCreatedAfter(?int $createdAfter): self
    {
        $this->createdAfter = $createdAfter;
        return $this;
    }

    public function getAfterId(): ?string
    {
        return $this->afterId;
    }

    public function setAfterId(?string $afterId): self
    {
        $this->afterId = $afterId;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function initFromString(string $filter): void
    {
        $params = explode("&", $filter);
        foreach ($params as $param) {
            $filterItem = explode('=', $param);
            switch ($filterItem[0]) {
                case 'createdAtAfter': $this->setCreatedAfter($filterItem[1]);
                break;
                case 'email': $this->setEmail($filterItem[1]);
                break;
                case 'after': $this->setAfterId($filterItem[1]);
                break;
            }
        }
    }

    public function toGetQuery(): string
    {
        $query = '';
        if ($this->getEmail()) {
            $query .= 'email=' . $this->getEmail() . '&';
        }
        if ($this->getAfterId()) {
            $query .= 'after=' . $this->getAfterId() . '&';
        }
        if ($this->getCreatedAfter()) {
            $query .= 'createdAtAfter=' . $this->getCreatedAfter();
        }

        return $query;
    }

    public function toRequest(): array
    {
        $request = [];
        if ($this->getEmail()) {
            $request['email'] = $this->getEmail();
        }
        if ($this->getAfterId()) {
            $request['after'] = $this->getAfterId();
        }
        if ($this->getCreatedAfter()) {
            $request['createdAtAfter'] = $this->getCreatedAfter();
        }

        return $request;
    }
}
