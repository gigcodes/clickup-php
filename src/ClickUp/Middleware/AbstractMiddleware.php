<?php

namespace ClickUp\Middleware;

use ClickUp\Client;

/**
 * Class AbstractMiddleware.
 */
abstract class AbstractMiddleware
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * AbstractMiddleware constructor.
     *
     * @param $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }
}
