<?php

namespace ClickUp\Objects;

use ClickUp\Client;

/**
 * Class AbstractObject
 */
abstract class AbstractObject
{
    private Client $client;

    private array $extra;
    
    public function __construct(Client $client, array $array)
    {
        $this->setClient($client);
        $this->fromArray($array);
        $this->setExtra($array);
    }

    private function setClient(Client $client): void
    {
        $this->client = $client;
    }

    abstract protected function fromArray($array);

    private function setExtra($array): void
    {
        $this->extra = $array;
    }

    public function extra(): array
    {
        return $this->extra;
    }

    protected function client(): Client
    {
        return $this->client;
    }
}
