<?php

namespace BothelpSDK\Resource\Subscriber;

use BothelpSDK\BothelpClient;
use BothelpSDK\Config\Endpoints;
use BothelpSDK\Entities\Subscriber\Subscriber;
use BothelpSDK\Entities\Subscriber\SubscribersList;
use BothelpSDK\Request\Subscriber\SubscriberFilter;
use BothelpSDK\Entities\Subscriber\ActionData;
use BothelpSDK\Request\Subscriber\SubscriberId;
use BothelpSDK\Exception\ValidateException;

class SubscriberService
{
    private BothelpClient $client;

    public function __construct(BothelpClient $client)
    {
        $this->client = $client;
    }

    public function list(?SubscriberFilter $filter): SubscribersList
    {
        $query = ($filter) ? $filter->toGetQuery() : '';
        $response = $this->client->apiRequest(
            'GET',
            Endpoints::SUBSCRIBERS_RESOURCE . '?' . $query
        );

        $list = new SubscribersList();
        foreach ($response['data'] as $subscriber) {
            $list[] = $this->mapResponseEntity($subscriber);
        }
        if (isset($response['paging'])) {
            $list->setHasNext(true);
            $next = new SubscriberFilter();
            $next->initFromString($response['paging']['next']);
            $list->setNextFilter($next);
        }

        return $list;
    }

    public function setPhone(SubscriberId $id, string $phone): array
    {
        if ($id->getId()) {
            return $this->subscriberRequestById(
                $id->getId(),
                $this->makeCommonFieldsActionData(ActionData::PATH_PHONE, $phone)
            );
        } elseif ($id->getCuid()) {
            return $this->subscriberRequestByCUID(
                $id->getCuid(),
                $this->makeCommonFieldsActionData(ActionData::PATH_PHONE, $phone)
            );
        }

        throw new ValidateException('Undefined subscriber identification');
    }

    public function setEmail(SubscriberId $id, string $email): array
    {
        if ($id->getId()) {
            return $this->subscriberRequestById(
                $id->getId(),
                $this->makeCommonFieldsActionData(ActionData::PATH_EMAIL, $email)
            );
        } elseif ($id->getCuid()) {
            return $this->subscriberRequestByCUID(
                $id->getCuid(),
                $this->makeCommonFieldsActionData(ActionData::PATH_EMAIL, $email)
            );
        }

        throw new ValidateException('Undefined subscriber identification');
    }

    public function setName(SubscriberId $id, string $name): array
    {
        if ($id->getId()) {
            return $this->subscriberRequestById(
                $id->getId(),
                $this->makeCommonFieldsActionData(ActionData::PATH_NAME, $name)
            );
        } elseif ($id->getCuid()) {
            return $this->subscriberRequestByCUID(
                $id->getCuid(),
                $this->makeCommonFieldsActionData(ActionData::PATH_NAME, $name)
            );
        }

        throw new ValidateException('Undefined subscriber identification');
    }

    public function setFirstName(SubscriberId $id, string $firstName): array
    {
        if ($id->getId()) {
            return $this->subscriberRequestById(
                $id->getId(),
                $this->makeCommonFieldsActionData(ActionData::PATH_FIRST_NAME, $firstName)
            );
        } elseif ($id->getCuid()) {
            return $this->subscriberRequestByCUID(
                $id->getCuid(),
                $this->makeCommonFieldsActionData(ActionData::PATH_FIRST_NAME, $firstName)
            );
        }

        throw new ValidateException('Undefined subscriber identification');
    }

    public function setLastName(SubscriberId $id, string $lastName): array
    {
        if ($id->getId()) {
            return $this->subscriberRequestById(
                $id->getId(),
                $this->makeCommonFieldsActionData(ActionData::PATH_LAST_NAME, $lastName)
            );
        } elseif ($id->getCuid()) {
            return $this->subscriberRequestByCUID(
                $id->getCuid(),
                $this->makeCommonFieldsActionData(ActionData::PATH_LAST_NAME, $lastName)
            );
        }

        throw new ValidateException('Undefined subscriber identification');
    }

    public function setNotes(SubscriberId $id, string $notes): array
    {
        if ($id->getId()) {
            return $this->subscriberRequestById(
                $id->getId(),
                $this->makeCommonFieldsActionData(ActionData::PATH_NOTES, $notes)
            );
        } elseif ($id->getCuid()) {
            return $this->subscriberRequestByCUID(
                $id->getCuid(),
                $this->makeCommonFieldsActionData(ActionData::PATH_NOTES, $notes)
            );
        }

        throw new ValidateException('Undefined subscriber identification');
    }

    public function setTags(SubscriberId $id, array $tags): array
    {
        if ($id->getId()) {
            return $this->subscriberRequestById(
                $id->getId(),
                (new ActionData())
                    ->setOp(ActionData::OP_ADD)
                    ->setPath(ActionData::PATH_TAGS)
                    ->setValue($tags)
            );
        } elseif ($id->getCuid()) {
            return $this->subscriberRequestByCUID(
                $id->getCuid(),
                (new ActionData())
                    ->setOp(ActionData::OP_ADD)
                    ->setPath(ActionData::PATH_TAGS)
                    ->setValue($tags)
            );
        }

        throw new ValidateException('Undefined subscriber identification');
    }

    public function removeTags(SubscriberId $id, array $tags): array
    {
        if ($id->getId()) {
            return $this->subscriberRequestById(
                $id->getId(),
                (new ActionData())
                    ->setOp(ActionData::OP_REMOVE)
                    ->setPath(ActionData::PATH_TAGS)
                    ->setValue($tags)
            );
        } elseif ($id->getCuid()) {
            return $this->subscriberRequestByCUID(
                $id->getCuid(),
                (new ActionData())
                    ->setOp(ActionData::OP_REMOVE)
                    ->setPath(ActionData::PATH_TAGS)
                    ->setValue($tags)
            );
        }

        throw new ValidateException('Undefined subscriber identification');
    }

    private function makeCommonFieldsActionData(string $path, $value): ActionData
    {
        return (new ActionData())
            ->setOp(ActionData::OP_REPLACE)
            ->setPath($path)
            ->setValue($value);
    }

    private function subscriberRequestById(int $chatId, ActionData $actionData): array
    {
        return $this->client->apiRequest(
            'PATCH',
            Endpoints::SUBSCRIBERS_RESOURCE . '/' . $chatId,
            [$actionData->toArray()]
        );
    }

    private function subscriberRequestByCUID(string $cuid, ActionData $actionData): array
    {
        return $this->client->apiRequest(
            'PATCH',
            Endpoints::SUBSCRIBERS_RESOURCE . '/' . Endpoints::CUID_RESOURCE . '/' . $cuid,
            [$actionData->toArray()]
        );
    }

    private function mapResponseEntity(array $response): Subscriber
    {
        return (new Subscriber())
            ->setRawData($response)
            ->setId($response['id'])
            ->setCuid($response['cuid'])
            ->setCreatedAt($response['createdAt'])
            ->setName($response['name'])
            ->setEmail($response['email'])
            ->setPhone($response['phone'])
            ->setChannelName($response['channelName'])
            ->setChannelType($response['channelType'])
            ->setUtmMedium($response['utmMedium'])
            ->setUtmCampaign($response['utmCampaign'])
            ->setUtmTerm($response['utmTerm'])
            ->setUtmSource($response['utmSource'])
            ->setUtmContent($response['utmContent'])
            ->setTags($response['tags']);
    }
}
