<?php

namespace ClickUp;

/**
 * Class Options
 */
class Options
{
    /**
     * Rest Limit Total
     */
    public const HEADER_REST_API_LIMITS = 'X-RateLimit-Limit';

    /**
     * Rest Limit Total Remaining
     */
    public const HEADER_REST_API_LIMITS_REMAINING = 'X-RateLimit-Remaining';

    /**
     * Access Token
     */
    protected ?string $accessToken;

    /**
     * API version
     */
    protected int $apiVersion = 2;

    /**
     * Additional Guzzle options
     */
    protected array $guzzleOptions = [
        'headers' => [
            'Content-Type' => 'application/json',
        ],
        'timeout' => 10.0,
        'max_retry_attempts' => 3,
        'default_retry_multiplier' => 2.0,
        'retry_on_status' => [429, 503, 500],
    ];

    /**
     * Guzzle handler (Optional)
     */
    protected $guzzleHandler = null;

    /**
     * API rate limit
     */
    protected int $rateLimit = 100;

    /**
     * Options constructor
     */
    public function __construct(?string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Get the Access Token
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * Get a unique storage key based on the access token
     */
    public function getStoreKey(): ?string
    {
        return substr(md5($this->accessToken . 'storage_key'), 0, 12);
    }

    /**
     * Get URI with API version
     */
    public function getUriWithVersion(): string
    {
        return "https://api.clickup.com/api/v{$this->getApiVersion()}/";
    }

    /**
     * Get the API version
     */
    public function getApiVersion(): int
    {
        return $this->apiVersion;
    }

    /**
     * Get Guzzle options
     */
    public function getGuzzleOptions(): array
    {
        return $this->guzzleOptions;
    }

    /**
     * Set Guzzle options, merging with existing options
     */
    public function setGuzzleOptions(array $options): void
    {
        $this->guzzleOptions = array_merge($this->guzzleOptions, $options);
    }

    /**
     * Get the Guzzle handler
     */
    public function getGuzzleHandler(): ?callable
    {
        return $this->guzzleHandler;
    }

    /**
     * Get the API rate limit
     */
    public function getRateLimit(): int
    {
        return $this->rateLimit;
    }
}
