<?php

namespace ClickUp\Traits;

use ClickUp\Client;
use ClickUp\Objects\Task;
use ClickUp\Objects\TaskCollection;
use ClickUp\Objects\TaskFinder;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Trait TaskFinderTrait
 *
 * Provides methods to find tasks and their collections.
 */
trait TaskFinderTrait
{
    /**
     * Retrieve a collection of tasks with optional sub-task and closed task inclusion.
     *
     * @param bool $includeSubTask Whether to include sub-tasks
     * @param bool $includeClosed Whether to include closed tasks
     *
     * @return TaskCollection The retrieved collection of tasks
     *
     * @throws GuzzleException If there's an error communicating with the API
     */
    public function tasks(bool $includeSubTask = false, bool $includeClosed = false): TaskCollection
    {
        return $this
            ->taskFinder()
            ->includeSubTask($includeSubTask)
            ->includeClosed($includeClosed)
            ->getCollection();
    }

    /**
     * Retrieve a `TaskFinder` object.
     *
     * @return TaskFinder A `TaskFinder` instance with the appropriate parameters
     */
    public function taskFinder(): TaskFinder
    {
        return (new TaskFinder($this->client(), $this->teamId()))->addParams($this->taskFindParams());
    }

    /**
     * Retrieve the client instance.
     *
     * @return Client The `Client` instance used to make API requests
     */
    abstract public function client(): Client;

    /**
     * Retrieve the team ID.
     *
     * @return int The team ID associated with the current client
     */
    abstract public function teamId(): int;

    /**
     * Retrieve additional task finding parameters.
     *
     * @return array Additional parameters for task finding
     */
    protected function taskFindParams(): array
    {
        return [];
    }

    /**
     * Process tasks in chunks using a callback function.
     *
     * @param bool $includeSubTask Whether to include sub-tasks
     * @param bool $includeClosed Whether to include closed tasks
     * @param callable|null $callback A callback function to process each chunk
     *
     * @return bool `True` if all chunks were processed successfully, otherwise `False`
     *
     * @throws GuzzleException If there's an error communicating with the API
     */
    public function tasksChunk(bool $includeSubTask = false, bool $includeClosed = false, ?callable $callback = null): bool
    {
        $page = 0;

        do {
            $tasks = null;

            try {
                $tasks = $this
                    ->taskFinder()
                    ->includeSubTask($includeSubTask)
                    ->includeClosed($includeClosed)
                    ->addParams(['page' => $page])
                    ->getCollection();

                $issetTasks = $tasks->isNotEmpty();
                $tasks = $tasks->objects();
            } catch (Exception $exception) {
            }

            if (empty($issetTasks)) {
                break;
            }

            if ($callback === null || $callback($tasks) === false) {
                return false;
            }

            unset($tasks);
            $page++;
        } while (true);

        return true;
    }

    /**
     * Retrieve a single task by its ID.
     *
     * @param string $taskId The ID of the task to retrieve
     *
     * @return Task The retrieved task
     *
     * @throws GuzzleException If there's an error communicating with the API
     */
    public function task(string $taskId): Task
    {
        return $this->taskFinder()->getByTaskId($taskId);
    }
}
