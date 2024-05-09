<?php

namespace ClickUp\Traits;

use DateTimeImmutable;
use Exception;

/**
 * Trait DateImmutableTrait.
 */
trait DateImmutableTrait
{
    /**
     * @param $array
     * @param $key
     *
     * @throws Exception
     *
     * @return DateTimeImmutable|null
     */
    private function getDate($array, $key): ?DateTimeImmutable
    {
        if (!isset($array[$key])) {
            return null;
        }
        $unixTime = substr($array[$key], 0, 10);

        return new DateTimeImmutable("@$unixTime");
    }

    /**
     * @return float
     */
    private function getCurrentDate(): float
    {
        return round(microtime(true) * 1000);
    }
}
