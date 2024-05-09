<?php

namespace ClickUp\Middleware;

use ClickUp\Options;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class UpdateApiLimits.
 */
class UpdateApiLimits extends AbstractMiddleware
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
            $promise = $handler($request, $options);

            return $promise->then(
                function (ResponseInterface $response) use ($self) {
                    $rateLimitTotal = $response->getHeader(Options::HEADER_REST_API_LIMITS)[0];
                    $rateLimitRemaining = $response->getHeader(Options::HEADER_REST_API_LIMITS_REMAINING)[0];

                    if (!$rateLimitTotal || !$rateLimitRemaining) {
                        return $response;
                    }

                    $client = $self->client;
                    $client->getStoreOptions()->getLimitStore()->push(
                        [
                            'left'  => (int) $rateLimitTotal - (int) $rateLimitRemaining,
                            'made'  => (int) $rateLimitRemaining,
                            'limit' => (int) $rateLimitTotal,
                        ],
                        $client->getOptions()
                    );

                    return $response;
                }
            );
        };
    }
}
