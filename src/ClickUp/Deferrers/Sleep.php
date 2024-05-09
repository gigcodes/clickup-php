<?php

namespace ClickUp\Deferrers;

use ClickUp\Contracts\TimeDeferrer;

/**
 * Class Sleep.
 *
 * This class provides an implementation of the TimeDeferrer interface using `usleep` to pause execution.
 */
class Sleep implements TimeDeferrer
{
    /**
     * Get the current time in microseconds.
     *
     * @return float The current time as a Unix timestamp with microsecond precision
     */
    public function getCurrentTime(): float
    {
        // Returns the current time as microseconds, so multiply by 1,000,000 (one million)
        return microtime(true) * 1000000;
    }

    /**
     * Pause execution for the specified number of microseconds.
     *
     * @param float $microseconds The duration to sleep in microseconds
     *
     * @return void
     */
    public function sleep(float $microseconds): void
    {
        // The usleep function expects an integer value representing microseconds
        usleep((int) $microseconds);
    }
}
