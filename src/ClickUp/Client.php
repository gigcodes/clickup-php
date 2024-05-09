<?php

namespace ClickUp;

use ClickUp\Middleware\AuthRequest;
use ClickUp\Middleware\RateLimiting;
use ClickUp\Middleware\UpdateApiLimits;
use ClickUp\Middleware\UpdateRequestTime;
use ClickUp\Objects\TaskFinder;
use ClickUp\Objects\Team;
use ClickUp\Objects\TeamCollection;
use ClickUp\Objects\User;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Utils;
use GuzzleRetry\GuzzleRetryMiddleware;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Client
 */
class Client
{
    /**
     * @var GuzzleHttpClient
     */
    private GuzzleHttpClient $guzzleClient;

    /**
     * The handler stack.
     *
     * @var HandlerStack
     */
    private HandlerStack $handlerStack;

    /**
     * Options.
     *
     * @var Options
     */
    private Options $options;

    /**
     * Store options.
     *
     * @var StoreOptions
     */
    private StoreOptions $storeOptions;

    /**
     * Client constructor.
     *
     * @param Options $options
     * @param StoreOptions|null $storeOptions
     */
    public function __construct(Options $options, ?StoreOptions $storeOptions = null)
    {
        $this->setOptions($options);
        $this->setStoreOptions($storeOptions ?? new StoreOptions());

        $this->setGuzzleClient();
    }

    /**
     * Set up the Guzzle client with a configured handler stack.
     *
     * @return void
     */
    protected function setGuzzleClient(): void
    {
        $this->handlerStack = HandlerStack::create($this->getOptions()->getGuzzleHandler());

        $this
            ->addMiddleware(new AuthRequest($this), 'request:auth')
            ->addMiddleware(new UpdateApiLimits($this), 'rate:update')
            ->addMiddleware(new UpdateRequestTime($this), 'time:update')
            ->addMiddleware(GuzzleRetryMiddleware::factory(), 'request:retry')
            ->addMiddleware(new RateLimiting($this), 'rate:limiting');

        $this->getOptions()->setGuzzleOptions(
            ['base_uri' => $this->getOptions()->getUriWithVersion()]
        );

        $this->guzzleClient = new GuzzleHttpClient(array_merge(
            ['handler' => $this->handlerStack],
            $this->getOptions()->getGuzzleOptions()
        ));
    }

    /**
     * Get the options.
     *
     * @return Options
     */
    public function getOptions(): Options
    {
        return $this->options;
    }

    /**
     * Set the options.
     *
     * @param Options $options
     */
    public function setOptions(Options $options): void
    {
        $this->options = $options;
    }

    /**
     * Add a middleware to the handler stack.
     *
     * @param callable $callable The middleware callable
     * @param string $name The middleware name
     *
     * @return Client
     */
    public function addMiddleware(callable $callable, string $name = ''): Client
    {
        $this->handlerStack->push($callable, $name);
        return $this;
    }

    /**
     * Get the store options.
     *
     * @return StoreOptions
     */
    public function getStoreOptions(): StoreOptions
    {
        return $this->storeOptions;
    }

    /**
     * Set the store options.
     *
     * @param StoreOptions $storeOptions
     */
    public function setStoreOptions(StoreOptions $storeOptions): void
    {
        $this->storeOptions = $storeOptions;
    }

    /**
     * Get the client instance.
     *
     * @return Client
     */
    public function client(): Client
    {
        return $this;
    }

    /**
     * Get the current user.
     *
     * @return User
     *
     * @throws GuzzleException
     */
    public function user(): User
    {
        return new User($this, $this->get('user')['user']);
    }

    /**
     * Get a team by its ID.
     *
     * @param int|string $teamId
     *
     * @return Team
     *
     * @throws GuzzleException
     */
    public function team(int|string $teamId): Team
    {
        return $this->teams()->getByKey($teamId);
    }

    /**
     * Get all teams.
     *
     * @return TeamCollection
     *
     * @throws GuzzleException
     */
    public function teams(): TeamCollection
    {
        return new TeamCollection(
            $this,
            $this->get('team')['teams']
        );
    }

    /**
     * Get a task finder for a given team.
     *
     * @param int $teamId
     *
     * @return TaskFinder
     */
    public function taskFinder(int $teamId): TaskFinder
    {
        return new TaskFinder($this, $teamId);
    }

    /**
     * Send a GET request.
     *
     * @param string $method The method endpoint
     * @param array $params The query parameters
     *
     * @return array|bool|float|int|object|string|null
     *
     * @throws GuzzleException
     */
    public function get(string $method, array $params = [])
    {
        $response = $this->guzzleClient->request('GET', $method, ['query' => $params]);
        return $this->decodeBody($response);
    }

    /**
     * Send a POST request.
     *
     * @param string $method The method endpoint
     * @param array $body The request body
     *
     * @return array|bool|float|int|object|string|null
     *
     * @throws GuzzleException
     */
    public function post(string $method, array $body = [])
    {
        $response = $this->guzzleClient->request('POST', $method, ['json' => $body]);
        return $this->decodeBody($response);
    }

    /**
     * Send a PUT request.
     *
     * @param string $method The method endpoint
     * @param array $body The request body
     *
     * @return array|bool|float|int|object|string|null
     *
     * @throws GuzzleException If the request fails
     */
    public function put(string $method, array $body = [])
    {
        $response = $this->guzzleClient->request('PUT', $method, ['json' => $body]);
        return $this->decodeBody($response);
    }

    /**
     * Decode a response body.
     *
     * @param ResponseInterface $response The response to decode
     *
     * @return mixed
     */
    public function decodeBody(ResponseInterface $response)
    {
        return method_exists(Utils::class, 'jsonDecode')
            ? Utils::jsonDecode($response->getBody(), true)
            : json_decode($response->getBody(), true);
    }
}
