<?php

namespace ClickUp\Objects;

use ClickUp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class TaskFinder.
 *
 *
 * @see https://jsapi.apiary.io/apis/clickup20/reference/0/tasks/get-filtered-team-tasks.html
 */
class TaskFinder
{
    /* @var Client $client */
    private $client;

    /* @var int $teamId */
    private $teamId;

    /* @var array $params */
    private $params = [];

    /**
     * @param Client $client
     * @param int    $teamId
     */
    public function __construct(Client $client, int $teamId)
    {
        $this->client = $client;
        $this->teamId = $teamId;
    }

    /**
     * @param $taskId
     *
     * @throws GuzzleException
     *
     * @return Task
     */
    public function getByTaskId($taskId): Task
    {
        return $this
            ->includeSubTask()
            ->includeClosed()
            ->addParams(['task_ids' => [$taskId]])
            ->getCollection()
            ->getByKey($taskId);
    }

    /**
     * @throws GuzzleException
     *
     * @return TaskCollection
     */
    public function getCollection(): TaskCollection
    {
        return new TaskCollection(
            $this->client,
            $this->client->get("team/{$this->teamId}/task", $this->params)['tasks'],
            $this->teamId
        );
    }

    public function addParams($params): TaskFinder
    {
        $this->params = array_merge_recursive($this->params, $params);

        return $this;
    }

    public function includeClosed($include = true): TaskFinder
    {
        $this->addParams(['include_closed' => $include]);

        return $this;
    }

    public function includeSubTask($include = true): TaskFinder
    {
        $this->addParams(['subtasks' => $include]);

        return $this;
    }

    public function resetParams()
    {
        $this->params = [];
    }
}
