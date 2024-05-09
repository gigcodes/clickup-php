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

    private int $id;
    private string $name;
    private int $orderIndex;
    private bool $isHidden;
    private string $taskCount;
    private TaskListCollection $taskLists;
    private bool $overrideStatuses;
    private ?StatusCollection $statuses = null;
    private int $spaceId;
    private Space $space;

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
     * @return StatusCollection|null
     */
    public function statuses(): ?StatusCollection
    {
        return $this->statuses;
    }

    public function spaceId(): int
    {
        return $this->spaceId;
    }

    public function setSpaceId(int $spaceId): void
    {
        $this->spaceId = $spaceId;
    }

    /**
     * @param Space $space
     */
    public function setSpace(Space $space): void
    {
        $this->space = $space;
    }

    /**
     * @param StatusCollection $statuses
     */
    public function setStatuses(StatusCollection $statuses): void
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
    protected function fromArray($array): void
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
