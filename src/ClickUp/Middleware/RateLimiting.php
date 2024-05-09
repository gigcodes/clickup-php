<?php

namespace ClickUp\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class RateLimiting
 *
 * Middleware class that implements rate limiting to manage request rates.
 */
class RateLimiting extends AbstractMiddleware
{
    /**
     * Invoke the middleware to apply rate limiting to outgoing requests.
     *
     * @param callable $handler The next handler in the middleware chain
     *
     * @return callable A handler function that applies rate limiting
     */
    public function __invoke(callable $handler): callable
    {

        return function (RequestInterface $request, array $options) use ($handler) {
            $self = $this;
            $client = $self->client;
            $timeStore = $client->getStoreOptions()->getTimeStore();
            $timeDeferrer = $client->getStoreOptions()->getTimeDeferrer();

            $times = $timeStore->get($client->getOptions());
            $rateLimit = $client->getOptions()->getRateLimit();

            // If the rate limit is reached, implement the rate limiting logic
            if (count($times) >= $rateLimit) {
                $firstTime = end($times);
                $windowTime = $firstTime + 1000000; // 1 million microseconds = 1 second
                $currentTime = $timeDeferrer->getCurrentTime();

                if ($currentTime <= $windowTime) {
                    $sleepTime = $windowTime - $currentTime;
                    $timeDeferrer->sleep(max($sleepTime, 0));
                }

                $timeStore->reset($client->getOptions());
            }

            return $handler($request, $options);
        };
    }
}
