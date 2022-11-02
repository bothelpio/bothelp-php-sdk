<?php

namespace BothelpSDK\Entities\Subscriber;

use ArrayAccess;
use ArrayIterator;
use BothelpSDK\Exception\InvalidListItemException;
use BothelpSDK\Request\Subscriber\SubscriberFilter;
use Countable;
use IteratorAggregate;

class SubscribersList implements Countable, IteratorAggregate, ArrayAccess
{
    protected array $items = [];

    protected bool $hasNext = false;

    protected ?SubscriberFilter $nextFilter = null;

    public function __construct()
    {
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->items);
    }

    public function offsetGet($offset): Subscriber
    {
        return $this->items[$offset];
    }

    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items ?? []);
    }

    public function offsetSet($offset, $value)
    {
        if (!$value instanceof Subscriber) {
            throw new InvalidListItemException('Incorrect instance of Subscriber');
        }

        if (null === $offset) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function hasNext(): bool
    {
        return $this->hasNext;
    }

    public function setHasNext(bool $hasNext): self
    {
        $this->hasNext = $hasNext;
        return $this;
    }

    public function getNextFilter(): ?SubscriberFilter
    {
        return $this->nextFilter;
    }

    public function setNextFilter(?SubscriberFilter $nextFilter): self
    {
        $this->nextFilter = $nextFilter;
        return $this;
    }

    public function toArray(): array
    {
        $list = [];
        /** @var Subscriber $item */
        foreach ($this->items as $item) {
            $list[] = $item->getRawData();
        }

        return $list;
    }
}
