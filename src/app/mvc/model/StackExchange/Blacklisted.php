<?php namespace com\github\gooh\CVBacklog;

class Blacklisted
{
    protected $client;
    protected $blacklistedQuestionIds;

    public function __construct(Client $client, array $blacklistedQuestionIds = array())
    {
        $this->client = $client;
        $this->blacklistedQuestionIds = $blacklistedQuestionIds;
    }

    public function findByIds(array $ids)
    {
        return $this->client->findByIds(
            array_diff($ids, $this->blacklistedQuestionIds)
        );
    }
}
