<?php

namespace ClickUp\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class UpdateRequestTime
 *
 * Middleware class to update request times in the store.
 */
class UpdateRequestTime extends AbstractMiddleware
{
    /**
     * Invoke the middleware to update request times.
     *
     * @param callable $handler The next handler in the middleware chain
     *
     * @return callable A handler function that updates request times
     */
    public function __invoke(callable $handler): callable
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            $self = $this;
            $client = $self->client;

            $client->getStoreOptions()->getTimeStore()->push(
                $client->getStoreOptions()->getTimeDeferrer()->getCurrentTime(),
                $client->getOptions()
            );

            return $handler($request, $options);
        };
    }
}
