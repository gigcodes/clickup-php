<?php

namespace ClickUp\Objects;

use ClickUp\Client;

/**
 * Class AbstractObject.
 */
abstract class AbstractObject
{
    /* @var Client $client */
    private $client;

    /* @var array $extra */
    private $extra;

    /**
     * @param Client $client
     * @param array  $array
     */
    public function __construct(Client $client, array $array)
    {
        $this->setClient($client);
        $this->fromArray($array);
        $this->setExtra($array);
    }

    private function setClient(Client $client)
    {
        $this->client = $client;
    }

    abstract protected function fromArray($array);

    private function setExtra($array)
    {
        $this->extra = $array;
    }

    public function extra(): array
    {
        return $this->extra;
    }

    /**
     * @return Client
     */
    protected function client(): Client
    {
        return $this->client;
    }
}
