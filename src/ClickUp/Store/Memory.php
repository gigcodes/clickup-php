<?php

namespace ClickUp\Store;

use ClickUp\Contracts\StateStorage;
use ClickUp\Options;

/**
 * Class Memory.
 */
class Memory implements StateStorage
{
    /**
     * @var array
     */
    protected $container = [];

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->container;
    }

    /**
     * @inheritDoc
     */
    public function get(Options $options): array
    {
        return $this->container[$options->getStoreKey()] ?? [];
    }

    /**
     * @inheritDoc
     */
    public function set(array $values, Options $options)
    {
        $this->container[$options->getStoreKey()] = $values;
    }

    /**
     * @inheritDoc
     */
    public function push($value, Options $options)
    {
        $storeKey = $options->getStoreKey();
        if (!isset($this->container[$storeKey])) {
            $this->reset($options);
        }

        array_unshift($this->container[$storeKey], $value);
    }

    /**
     * @inheritDoc
     */
    public function reset(Options $options)
    {
        $this->container[$options->getStoreKey()] = [];
    }
}
