<?php

namespace ClickUp\Contracts;

/**
 * Interface TimeDeferrer.
 */
interface TimeDeferrer
{
    /**
     * Get current time.
     *
     * @return mixed
     */
    public function getCurrentTime();

    /**
     * Sleep.
     *
     * @param float $microseconds
     *
     * @return mixed
     */
    public function sleep(float $microseconds);
}
