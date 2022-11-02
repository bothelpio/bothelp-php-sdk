<?php

namespace BothelpSDK\Resource\Subscriber;

use BothelpSDK\BothelpClient;
use BothelpSDK\Config\Endpoints;
use BothelpSDK\Entities\Subscriber\Subscriber;
use BothelpSDK\Entities\Subscriber\SubscribersList;
use BothelpSDK\Request\Subscriber\SubscriberFilter;

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
