<?php

namespace ClickUp\Contracts;

/**
 * Interface TimeDeferrer.
 *
 * This interface defines methods for obtaining the current time and deferring execution for a specific duration.
 */
interface TimeDeferrer
{
    /**
     * Get the current time.
     *
     * @return float Current time as a Unix timestamp with microsecond precision
     */
    public function getCurrentTime(): float;

    /**
     * Pause execution for the specified duration in microseconds.
     *
     * @param float $microseconds Duration in microseconds to pause execution
     *
     * @return void
     */
    public function sleep(float $microseconds): void;
}
