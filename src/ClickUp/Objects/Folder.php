<?php

namespace ClickUp\Objects;

use ClickUp\Traits\TaskFinderTrait;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class Folder.
 */
class Folder extends AbstractObject
{
    use TaskFinderTrait;

    /* @var int $id */
    private $id;

    /* @var string $name */
    private $name;

    /** @var int */
    private $orderIndex;

    /** @var bool */
    private $isHidden;

    /** @var string */
    private $taskCount;

    /* @var TaskListCollection $taskLists */
    private $taskLists;

    /* @var bool $overrideStatuses */
    private $overrideStatuses;

    /* @var StatusCollection|null $statuses */
    private $statuses = null;

    /* @var int $spaceId */
    private $spaceId;

    /* @var Space $space */
    private $space;

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function orderIndex(): int
    {
        return $this->orderIndex;
    }

    /**
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->isHidden;
    }

    /**
     * @return string
     */
    public function taskCount(): string
    {
        return $this->taskCount;
    }

    /**
     * @param int $taskListId
     *
     * @return TaskList
     */
    public function taskList(int $taskListId): TaskList
    {
        return $this->taskLists()->getByKey($taskListId);
    }

    /**
     * @return TaskListCollection
     */
    public function taskLists(): TaskListCollection
    {
        return $this->taskLists;
    }

    /**
     * @return bool
     */
    public function overrideStatuses(): bool
    {
        return $this->overrideStatuses;
    }

    /**
     * @return StatusCollection
     */
    public function statuses(): ?StatusCollection
    {
        return $this->statuses;
    }

    public function spaceId(): int
    {
        return $this->spaceId;
    }

    public function setSpaceId($spaceId)
    {
        $this->spaceId = $spaceId;
    }

    /**
     * @param Space $space
     */
    public function setSpace(Space $space)
    {
        $this->space = $space;
    }

    /**
     * @param StatusCollection $statuses
     */
    public function setStatuses(StatusCollection $statuses)
    {
        $this->statuses = $statuses;
    }

    /**
     * @see https://jsapi.apiary.io/apis/clickup/reference/0/list/create-list.html
     *
     * @param array $body
     *
     * @throws GuzzleException
     *
     * @return TaskList|null
     */
    public function createTaskList(array $body): ?TaskList
    {
        return new TaskList(
            $this->client(),
            $this->client()->post(
                "folder/{$this->id()}/list",
                $body
            )
        );
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function teamId(): int
    {
        return $this->space()->team()->id();
    }

    /**
     * Access parent class.
     *
     * @return Space
     */
    public function space(): Space
    {
        return $this->space;
    }

    /**
     * @return array
     */
    protected function taskFindParams(): array
    {
        return ['folder_ids' => [$this->id()]];
    }

    /**
     * @param array $array
     */
    protected function fromArray($array)
    {
        $this->id = $array['id'];
        $this->name = $array['name'];
        $this->orderIndex = $array['orderindex'] ?? false;
        $this->isHidden = $array['hidden'] ?? false;
        $this->taskCount = $array['task_count'] ?? false;
        $this->taskLists = new TaskListCollection($this, $array['lists']);
        $this->overrideStatuses = $array['override_statuses'] ?? false;

        if (isset($array['override_statuses']) and $array['override_statuses']) {
            $this->statuses = new StatusCollection($this->client(), $array['statuses']);
        }
    }
}
