<?php

namespace ClickUp\Middleware;

use Psr\Http\Message\RequestInterface;

/**
 * Class RateLimiting.
 */
class RateLimiting extends AbstractMiddleware
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

            $timeStore = $client->getStoreOptions()->getTimeStore();
            $timeDeferrer = $client->getStoreOptions()->getTimeDeferrer();

            $times = $timeStore->get($client->getOptions());
            if (count($times) >= $client->getOptions()->getRateLimit()) {
                $firstTime = end($times);
                $windowTime = $firstTime + 1000000;
                $currentTime = $timeDeferrer->getCurrentTime();

                if ($currentTime <= $windowTime) {
                    $sleepTime = $windowTime - $currentTime;
                    $timeDeferrer->sleep($sleepTime < 0 ? 0 : $sleepTime);
                }

                $timeStore->reset($client->getOptions());
            }

            return $handler($request, $options);
        };
    }
}
