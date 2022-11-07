<?php

namespace BothelpSDK\Resource\Message;

use BothelpSDK\BothelpClient;
use BothelpSDK\Config\Endpoints;
use BothelpSDK\Entities\Subscriber\ActionData;
use BothelpSDK\Exception\ValidateException;
use BothelpSDK\Request\Subscriber\SubscriberId;

class MessageService
{
    private BothelpClient $client;

    public function __construct(BothelpClient $client)
    {
        $this->client = $client;
    }

    public function send(SubscriberId $id, string $text): array
    {
        if ($id->getId()) {
            return $this->requestById($id->getId(), $text);
        } elseif ($id->getCuid()) {
            return $this->requestByCUID($id->getCuid(), $text);
        }

        throw new ValidateException('Undefined subscriber identification');
    }

    private function requestById(int $id, string $text): array
    {
        return $this->client->apiRequest(
            'POST',
            Endpoints::SUBSCRIBERS_RESOURCE
            . '/' . $id
            . '/' . Endpoints::MESSAGES_RESOURCE,
            [['content' => $text]]
        );
    }

    private function requestByCUID(string $cuid, string $text): array
    {
        return $this->client->apiRequest(
            'POST',
            Endpoints::SUBSCRIBERS_RESOURCE
            . '/' . Endpoints::CUID_RESOURCE
            . '/' . $cuid
            . '/' . Endpoints::MESSAGES_RESOURCE,
            [['content' => $text]]
        );
    }
}
