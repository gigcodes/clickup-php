<?php

namespace ClickUp\Middleware;

use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AuthRequest
 *
 * Middleware class that handles adding the authorization header to requests.
 */
class AuthRequest extends AbstractMiddleware
{
    /**
     * Invoke.
     *
     * @param callable $handler The next handler in the middleware chain
     *
     * @return callable A handler function to handle the request and response
     */
    public function __invoke(callable $handler): callable
    {

        return function (RequestInterface $request, array $options) use ($handler) {
            $self = $this;
            $accessToken = $self->client->getOptions()->getAccessToken();

            if ($accessToken === null) {
                throw new Exception('Access Token parameter is required');
            }

            $request = $request->withHeader('Authorization', $accessToken);

            return $handler($request, $options);
        };
    }
}
