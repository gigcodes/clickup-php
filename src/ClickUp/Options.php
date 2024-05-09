<?php

namespace ClickUp;

/**
 * Class Option.
 */
class Options
{
    /**
     * Rest Limit Total.
     */
    public const HEADER_REST_API_LIMITS = 'X-RateLimit-Limit';

    /**
     * Rest Limit Total Remaining.
     */
    public const HEADER_REST_API_LIMITS_REMAINING = 'X-RateLimit-Remaining';

    /**
     * Access Token.
     *
     * @var string|null
     */
    protected $accessToken;

    /**
     * Api version.
     *
     * @var int
     */
    protected $apiVersion = 2;

    /**
     * Additional Guzzle options.
     *
     * @var array
     */
    protected $guzzleOptions = [
        'headers' => [
            'Content-Type' => 'application/json',
        ],
        'timeout'                  => 10.0,
        'max_retry_attempts'       => 3,
        'default_retry_multiplier' => 2.0,
        'retry_on_status'          => [429, 503, 500],
    ];

    /**
     * Guzzle handler [Optional].
     *
     * @var callable|null
     */
    protected $guzzleHandler;

    /**
     * API rate limit.
     *
     * @var int
     */
    protected $rateLimit = 100;

    /**
     * Option constructor.
     *
     * @param $accessToken
     */
    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Get Access Token.
     *
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * Get Access Token.
     *
     * @return string|null
     */
    public function getStoreKey(): ?string
    {
        return substr(md5($this->accessToken.'storage_key'), 0, 12);
    }

    /**
     * Get URI With Version.
     *
     * @return string
     */
    public function getUriWithVersion(): string
    {
        return "https://api.clickup.com/api/v{$this->getApiVersion()}/";
    }

    /**
     * Get Api Version.
     *
     * @return int
     */
    public function getApiVersion(): int
    {
        return $this->apiVersion;
    }

    /**
     * Get Guzzle Options.
     *
     * @return array
     */
    public function getGuzzleOptions(): array
    {
        return $this->guzzleOptions;
    }

    /**
     * Set Guzzle Options.
     *
     * @param array $options
     */
    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = array_merge($this->guzzleOptions, $options);
    }

    /**
     * Get the Guzzle handler.
     *
     * @return callable|null
     */
    public function getGuzzleHandler(): ?callable
    {
        return $this->guzzleHandler;
    }

    /**
     * Get rate limit.
     *
     * @return int
     */
    public function getRateLimit(): int
    {
        return $this->rateLimit;
    }
}
