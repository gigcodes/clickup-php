<?php

namespace ClickUp;

use ClickUp\Contracts\StateStorage;
use ClickUp\Contracts\TimeDeferrer;
use ClickUp\Deferrers\Sleep;
use ClickUp\Store\Memory;

/**
 * Class StoreOptions.
 */
class StoreOptions
{
    /**
     * The time store.
     *
     * @var StateStorage
     */
    protected $timeStore;

    /**
     * The limits store.
     *
     * @var StateStorage
     */
    protected $limitStore;

    /**
     * The time deferrer.
     *
     * @var TimeDeferrer
     */
    protected $timeDeferrer;

    /**
     * StoreOptions constructor.
     *
     * @param StateStorage|null $tStore
     * @param StateStorage|null $lStore
     * @param TimeDeferrer|null $tDeferrer
     */
    public function __construct(
        ?StateStorage $tStore = null,
        ?StateStorage $lStore = null,
        ?TimeDeferrer $tDeferrer = null
    ) {
        $this->timeStore = $tStore === null ? new Memory() : clone $tStore;
        $this->limitStore = $lStore === null ? new Memory() : clone $lStore;
        $this->timeDeferrer = $tDeferrer === null ? new Sleep() : $tDeferrer;
    }

    /**
     * Get time deferrer.
     *
     * @return TimeDeferrer
     */
    public function getTimeDeferrer(): TimeDeferrer
    {
        return $this->timeDeferrer;
    }

    /**
     * Get time store.
     *
     * @return StateStorage
     */
    public function getTimeStore(): StateStorage
    {
        return $this->timeStore;
    }

    /**
     * Get limit store.
     *
     * @return StateStorage
     */
    public function getLimitStore(): StateStorage
    {
        return $this->limitStore;
    }
}
