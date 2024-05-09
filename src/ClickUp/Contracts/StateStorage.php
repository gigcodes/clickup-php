<?php

namespace ClickUp\Contracts;

use ClickUp\Options;

/**
 * Interface StateStorage.
 */
interface StateStorage
{
    /**
     * Get all stored values.
     *
     * @return array Array of stored values
     */
    public function all(): array;

    /**
     * Get the values based on provided options.
     *
     * @param Options $options Options to determine which values to retrieve
     *
     * @return array Array of values based on options
     */
    public function get(Options $options): array;

    /**
     * Set the values based on provided options.
     *
     * @param array   $values Values to be stored
     * @param Options $options Options to determine where to store the values
     *
     * @return void
     */
    public function set(array $values, Options $options): void;

    /**
     * Append a single value to the storage based on options.
     *
     * @param mixed   $value Value to be appended
     * @param Options $options Options to determine where to append the value
     *
     * @return void
     */
    public function push(mixed $value, Options $options): void;

    /**
     * Reset or remove all stored values based on options.
     *
     * @param Options $options Options to determine which values to reset
     *
     * @return void
     */
    public function reset(Options $options): void;
}
