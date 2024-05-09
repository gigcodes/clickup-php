<?php

namespace ClickUp\Middleware;

use Psr\Http\Message\RequestInterface;

/**
 * Class UpdateRequestTime.
 */
class UpdateRequestTime extends AbstractMiddleware
{
    /**
     * Invoke.
     *
     * @param callable $handler
     *
     * @return callable
     */
    public function __invoke(callable $handler): callable
    {
        $self = $this;

        return function (RequestInterface $request, array $options) use ($self, $handler) {
            $client = $self->client;

            $client->getStoreOptions()->getTimeStore()->push(
                $client->getStoreOptions()->getTimeDeferrer()->getCurrentTime(),
                $client->getOptions()
            );

            return $handler($request, $options);
        };
    }
}
