<?php

namespace BothelpSDK\Resource\CustomField;

use BothelpSDK\BothelpClient;
use BothelpSDK\Config\Endpoints;
use BothelpSDK\Entities\Subscriber\ActionData;
use BothelpSDK\Request\Subscriber\SubscriberId;
use BothelpSDK\Exception\ValidateException;

class CustomField
{
    private BothelpClient $client;

    public function __construct(BothelpClient $client)
    {
        $this->client = $client;
    }

    public function setField(SubscriberId $id, string $fieldName, string $fieldValue): array
    {
        if ($id->getId()) {
            return $this->subscriberRequestById(
                $id->getId(),
                $this->makeActionData($fieldName, $fieldValue)
            );
        } elseif ($id->getCuid()) {
            return $this->subscriberRequestByCUID(
                $id->getCuid(),
                $this->makeActionData($fieldName, $fieldValue)
            );
        }

        throw new ValidateException('Undefined subscriber identification');
    }

    private function makeActionData(string $fieldName, string $fieldValue): ActionData
    {
        if (substr($fieldName, 0, 1) != '/') {
            $fieldName = '/' . $fieldName;
        }
        return (new ActionData())
            ->setOp(ActionData::OP_REPLACE)
            ->setPath($fieldName)
            ->setValue($fieldValue);
    }
    private function subscriberRequestById(int $id, ActionData $actionData): array
    {
        return $this->client->apiRequest(
            'PATCH',
            Endpoints::SUBSCRIBERS_RESOURCE
            . '/' . $id
            . '/' . Endpoints::CUSTOMER_FIELDS_RESOURCE,
            [$actionData->toArray()]
        );
    }

    private function subscriberRequestByCUID(string $cuid, ActionData $actionData): array
    {
        return $this->client->apiRequest(
            'PATCH',
            Endpoints::SUBSCRIBERS_RESOURCE
                    . '/' . Endpoints::CUID_RESOURCE
                    . '/' . $cuid
                    . '/' . Endpoints::CUSTOMER_FIELDS_RESOURCE,
            [$actionData->toArray()]
        );
    }
}
