<?php

namespace ClickUp\Store;

use ClickUp\Contracts\StateStorage;
use ClickUp\Options;

/**
 * Class Memory
 *
 * In-memory state storage implementation of StateStorage interface.
 */
class Memory implements StateStorage
{
    /**
     * In-memory container for storing data.
     *
     * @var array<string, array>
     */
    protected array $container = [];

    /**
     * Retrieve all stored data.
     *
     * @return array<string, array>
     */
    public function all(): array
    {
        return $this->container;
    }

    /**
     * Retrieve data for a specific key based on options.
     *
     * @param Options $options Options containing the key for retrieval
     *
     * @return array The stored values associated with the given key
     */
    public function get(Options $options): array
    {
        return $this->container[$options->getStoreKey()] ?? [];
    }

    /**
     * Set data for a specific key.
     *
     * @param array $values Values to be stored
     * @param Options $options Options containing the key for storage
     *
     * @return void
     */
    public function set(array $values, Options $options): void
    {
        $this->container[$options->getStoreKey()] = $values;
    }

    /**
     * Push a new value to the front of the array for a specific key.
     *
     * @param mixed $value Value to be stored
     * @param Options $options Options containing the key for storage
     *
     * @return void
     */
    public function push(mixed $value, Options $options): void
    {
        $storeKey = $options->getStoreKey();
        if (!isset($this->container[$storeKey])) {
            $this->reset($options);
        }

        array_unshift($this->container[$storeKey], $value);
    }

    /**
     * Reset the stored values for a specific key.
     *
     * @param Options $options Options containing the key to reset
     *
     * @return void
     */
    public function reset(Options $options): void
    {
        $this->container[$options->getStoreKey()] = [];
    }
}
