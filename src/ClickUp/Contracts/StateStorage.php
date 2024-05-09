<?php

namespace ClickUp\Contracts;

use ClickUp\Options;

/**
 * Interface StateStorage.
 */
interface StateStorage
{
    /**
     * Get all.
     *
     * @return array
     */
    public function all(): array;

    /**
     * Get the values.
     *
     * @param Options $options
     *
     * @return array
     */
    public function get(Options $options): array;

    /**
     * Set the values.
     *
     * @param array   $values
     * @param Options $options
     *
     * @return void
     */
    public function set(array $values, Options $options);

    /**
     * Set the values.
     *
     * @param $value
     * @param Options $options
     *
     * @return void
     */
    public function push($value, Options $options);

    /**
     * Remove all values.
     *
     * @param Options $options
     *
     * @return void
     */
    public function reset(Options $options);
}
