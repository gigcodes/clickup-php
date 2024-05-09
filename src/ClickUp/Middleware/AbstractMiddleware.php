<?php

namespace ClickUp\Middleware;

use ClickUp\Client;

/**
 * Class AbstractMiddleware
 *
 * This class provides a base middleware class that defines common properties for middleware components.
 */
abstract class AbstractMiddleware
{
    /**
     * Client instance to be used by the middleware.
     *
     * @var Client
     */
    protected Client $client;

    /**
     * AbstractMiddleware constructor.
     *
     * @param Client $client Client instance required by the middleware
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
