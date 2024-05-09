<?php

namespace ClickUp;

use ClickUp\Contracts\StateStorage;
use ClickUp\Contracts\TimeDeferrer;
use ClickUp\Deferrers\Sleep;
use ClickUp\Store\Memory;

/**
 * Class StoreOptions
 */
class StoreOptions
{
    /**
     * The time store
     */
    protected StateStorage $timeStore;

    /**
     * The limits store
     */
    protected StateStorage $limitStore;

    /**
     * The time deferrer
     */
    protected TimeDeferrer $timeDeferrer;

    /**
     * StoreOptions constructor
     */
    public function __construct(
        ?StateStorage $tStore = null,
        ?StateStorage $lStore = null,
        ?TimeDeferrer $tDeferrer = null
    ) {
        $this->timeStore = $tStore ? clone $tStore : new Memory();
        $this->limitStore = $lStore ? clone $lStore : new Memory();
        $this->timeDeferrer = $tDeferrer ?? new Sleep();
    }

    /**
     * Get time deferrer
     */
    public function getTimeDeferrer(): TimeDeferrer
    {
        return $this->timeDeferrer;
    }

    /**
     * Get time store
     */
    public function getTimeStore(): StateStorage
    {
        return $this->timeStore;
    }

    /**
     * Get limit store
     */
    public function getLimitStore(): StateStorage
    {
        return $this->limitStore;
    }
}
