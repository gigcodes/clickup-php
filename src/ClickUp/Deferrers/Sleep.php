<?php

namespace ClickUp\Deferrers;

use ClickUp\Contracts\TimeDeferrer;

/**
 * Class Sleep.
 */
class Sleep implements TimeDeferrer
{
    /**
     * @inheritDoc
     */
    public function getCurrentTime(): int|float
    {
        return microtime(true) * 1000000;
    }

    /**
     * @inheritDoc
     */
    public function sleep(float $microseconds): void
    {
        usleep((int) $microseconds);
    }
}
