<?php

namespace ClickUp\Traits;

use DateTimeImmutable;
use Exception;

/**
 * Trait DateImmutableTrait
 *
 * Provides utilities for handling date-time conversion.
 */
trait DateImmutableTrait
{
    /**
     * Retrieve a `DateTimeImmutable` object based on an array key.
     *
     * @param array $array Array containing date values
     * @param string|int $key The key to look for in the array
     *
     * @return DateTimeImmutable|null A `DateTimeImmutable` object or null if the key doesn't exist
     *
     * @throws Exception If the DateTime conversion fails
     */
    private function getDate(array $array, string|int $key): ?DateTimeImmutable
    {
        if (!isset($array[$key])) {
            return null;
        }

        // Retrieve the first 10 characters representing Unix time and convert to `DateTimeImmutable`
        $unixTime = substr((string)$array[$key], 0, 10);

        return new DateTimeImmutable("@$unixTime");
    }

    /**
     * Get the current date in milliseconds.
     *
     * @return float Current date as a timestamp in milliseconds
     */
    private function getCurrentDate(): float
    {
        return round(microtime(true) * 1000);
    }
}
