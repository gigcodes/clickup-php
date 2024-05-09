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
 * Class Client.
 */
class Client
{
    /**
     * @var GuzzleHttpClient
     */
    private $guzzleClient;

    /**
     * The handler stack.
     *
     * @var HandlerStack
     */
    private $handlerStack;

    /**
     * Options.
     *
     * @var Options
     */
    private $options;

    /**
     * Store options.
     *
     * @var StoreOptions
     */
    private $storeOptions;

    /**
     * Client constructor.
     *
     * @param Options           $options
     * @param StoreOptions|null $storeOptions
     */
    public function __construct(Options $options, ?StoreOptions $storeOptions = null)
    {
        $this->setOptions($options);
        $this->setStoreOptions($storeOptions ?? new StoreOptions());

        $this->setGuzzleClient();
    }

    /**
     * @return void
     */
    protected function setGuzzleClient()
    {
        $this->handlerStack = HandlerStack::create($this->getOptions()->getGuzzleHandler());
        $this->addMiddleware(new AuthRequest($this), 'request:auth')
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
     * @return Options
     */
    public function getOptions(): Options
    {
        return $this->options;
    }

    /**
     * @param Options $options
     */
    public function setOptions(Options $options)
    {
        $this->options = $options;
    }

    /**
     * @param callable $callable
     * @param string   $name
     *
     * @return Client
     */
    public function addMiddleware(callable $callable, string $name = ''): Client
    {
        $this->handlerStack->push($callable, $name);

        return $this;
    }

    /**
     * @return StoreOptions
     */
    public function getStoreOptions(): StoreOptions
    {
        return $this->storeOptions;
    }

    /**
     * @param StoreOptions $storeOptions
     */
    public function setStoreOptions(StoreOptions $storeOptions)
    {
        $this->storeOptions = $storeOptions;
    }

    /**
     * @return $this
     */
    public function client(): Client
    {
        return $this;
    }

    /**
     * @throws GuzzleException
     *
     * @return User
     */
    public function user(): User
    {
        return new User($this, $this->get('user')['user']);
    }

    /**
     * @param $teamId
     *
     * @throws GuzzleException
     *
     * @return Team
     */
    public function team($teamId): Team
    {
        return $this->teams()->getByKey($teamId);
    }

    /**
     * @throws GuzzleException
     *
     * @return TeamCollection
     */
    public function teams(): TeamCollection
    {
        return new TeamCollection(
            $this,
            $this->get('team')['teams']
        );
    }

    /**
     * @param int $teamId
     *
     * @return TaskFinder
     */
    public function taskFinder(int $teamId): TaskFinder
    {
        return new TaskFinder($this, $teamId);
    }

    /**
     * @param string $method
     * @param array  $params
     *
     * @throws GuzzleException
     *
     * @return array|bool|float|int|object|string|null
     */
    public function get(string $method, array $params = [])
    {
        $response = $this->guzzleClient->request('GET', $method, ['query' => $params]);

        return $this->decodeBody($response);
    }

    /**
     * @param string $method
     * @param array  $body
     *
     * @throws GuzzleException
     *
     * @return array|bool|float|int|object|string|null
     */
    public function post(string $method, array $body = [])
    {
        $response = $this->guzzleClient->request('POST', $method, ['json' => $body]);

        return $this->decodeBody($response);
    }

    /**
     * @param string $method
     * @param array  $body
     *
     * @throws GuzzleException
     *
     * @return array|bool|float|int|object|string|null
     */
    public function put(string $method, array $body = [])
    {
        $response = $this->guzzleClient->request('PUT', $method, ['json' => $body]);

        return $this->decodeBody($response);
    }

    /**
     * Decode Body.
     *
     * @param ResponseInterface $response
     *
     * @return mixed
     */
    public function decodeBody(ResponseInterface $response)
    {
        if (method_exists(Utils::class, 'jsonDecode')) {
            return Utils::jsonDecode($response->getBody(), true);
        } else {
            return json_decode($response->getBody(), true);
        }
    }
}
