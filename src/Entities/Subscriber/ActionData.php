<?php


namespace BothelpSDK\Entities\Subscriber;


class ActionData
{
    public const OP_ADD = 'add';
    public const OP_REMOVE = 'remove';
    public const OP_REPLACE = 'replace';

    public const PATH_PHONE = '/phone';
    public const PATH_FIRST_NAME = '/firstName';
    public const PATH_LAST_NAME = '/lastName';
    public const PATH_NAME = '/name';
    public const PATH_EMAIL = '/email';
    public const PATH_NOTES = '/notes';
    public const PATH_TAGS = '/tags';

    private string $op;

    private string $path;

    private $value;

    public function getOp(): string
    {
        return $this->op;
    }

    public function setOp(string $op): self
    {
        $this->op = $op;
        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): self
    {
        $this->value = $value;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'op' => $this->getOp(),
            'path' => $this->getPath(),
            'value' => $this->getValue()
        ];
    }
}