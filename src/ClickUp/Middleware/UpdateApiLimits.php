<?php

namespace ClickUp\Middleware;

use ClickUp\Options;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Class UpdateApiLimits
 *
 * Middleware that updates API limit information from response headers.
 */
class UpdateApiLimits extends AbstractMiddleware
{
    /**
     * Invoke the middleware to update API limits.
     *
     * @param callable $handler The next handler in the middleware chain
     *
     * @return callable A handler function to handle API limit updates
     */
    public function __invoke(callable $handler): callable
    {
        $self = $this;

        return function (RequestInterface $request, array $options) use ($self, $handler): PromiseInterface {
            // Call the next handler and return a promise
            $promise = $handler($request, $options);

            // Add a callback to update the API limits based on the response headers
            return $promise->then(
                function (ResponseInterface $response) use ($self): ResponseInterface {
                    $rateLimitTotal = $response->getHeader(Options::HEADER_REST_API_LIMITS)[0] ?? null;
                    $rateLimitRemaining = $response->getHeader(Options::HEADER_REST_API_LIMITS_REMAINING)[0] ?? null;

                    if ($rateLimitTotal !== null && $rateLimitRemaining !== null) {
                        $client = $self->client;
                        $limitStore = $client->getStoreOptions()->getLimitStore();

                        $limits = [
                            'left' => (int)$rateLimitTotal - (int)$rateLimitRemaining,
                            'made' => (int)$rateLimitRemaining,
                            'limit' => (int)$rateLimitTotal
                        ];

                        $limitStore->push($limits, $client->getOptions());
                    }

                    return $response;
                }
            );
        };
    }
}
