<?php

namespace ClickUp\Traits;

use ClickUp\Client;
use ClickUp\Objects\Task;
use ClickUp\Objects\TaskCollection;
use ClickUp\Objects\TaskFinder;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Trait TaskFinderTrait.
 */
trait TaskFinderTrait
{
    /**
     * @param bool $includeSubTask
     * @param bool $includeClosed
     *
     * @throws GuzzleException
     *
     * @return TaskCollection
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
     * @return TaskFinder
     */
    public function taskFinder(): TaskFinder
    {
        return (new TaskFinder($this->client(), $this->teamId()))->addParams($this->taskFindParams());
    }

    /**
     * @return Client
     */
    abstract public function client(): Client;

    /**
     * @return int
     */
    abstract public function teamId(): int;

    /**
     * @return array
     */
    protected function taskFindParams(): array
    {
        return [];
    }

    /**
     * @param false         $includeSubTask
     * @param false         $includeClosed
     * @param callable|null $callback
     *
     * @throws GuzzleException
     *
     * @return bool
     */
    public function tasksChunk(bool $includeSubTask = false, bool $includeClosed = false, callable $callback = null): bool
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

            if ($callback == null || $callback($tasks) == false) {
                return false;
            }

            unset($tasks);
            $page++;
        } while (true);

        return true;
    }

    /**
     * @param string $taskId
     *
     * @throws GuzzleException
     *
     * @return Task
     */
    public function task(string $taskId): Task
    {
        return $this->taskFinder()->getByTaskId($taskId);
    }
}
