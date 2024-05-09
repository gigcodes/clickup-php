<?php

namespace ClickUp\Objects;

use ClickUp\Traits\DateImmutableTrait;
use ClickUp\Traits\TaskFinderTrait;
use DateTimeImmutable;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class Task.
 */
class Task extends AbstractObject
{
    use TaskFinderTrait;
    use DateImmutableTrait;

    /* @var string $id */
    private $id;

    /* @var string $name */
    private $name;

    /* @var string $description */
    private $description;

    /* @var Status $status */
    private $status;

    /* @var string $orderindex */
    private $orderindex;

    /* @var DateTimeImmutable $dateCreated */
    private $dateCreated;

    /* @var DateTimeImmutable $dateUpdated */
    private $dateUpdated;

    /* @var TeamMember $creator */
    private $creator;

    /* @var TeamMemberCollection $assignees */
    private $assignees;

    /* @var TagCollection $tags */
    private $tags;

    /* @var string|null $parentTaskId */
    private $parentTaskId;

    /* @var Task|null $parentTask */
    private $parentTask = null;

    /* @var int $priority */
    private $priority;

    /* @var DateTimeImmutable $dueDate */
    private $dueDate;

    /* @var DateTimeImmutable $startDate */
    private $startDate;

    /* @var int $points */
    private $points;

    /* @var string $timeEstimate */
    private $timeEstimate;

    /** @var CustomFieldCollection */
    private $customFields;

    /* @var int $taskListId */
    private $taskListId;

    /* @var TaskList|null $taskList */
    private $taskList = null;

    /* @var int $folderId */
    private $folderId;

    /* @var Folder|null $folder */
    private $folder = null;

    /* @var int $spaceId */
    private $spaceId;

    /* @var Space|null $space */
    private $space = null;

    /* @var int $teamId */
    private $teamId;

    /* @var Team|null $team */
    private $team = null;

    /* @var TaskCommentCollection|null $comment */
    private $comment = null;

    /* @var string $url */
    private $url;

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    /**
     * @return Status
     */
    public function status(): Status
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function orderindex(): string
    {
        return $this->orderindex;
    }

    /**
     * @return DateTimeImmutable
     */
    public function dateCreated(): DateTimeImmutable
    {
        return $this->dateCreated;
    }

    /**
     * @return DateTimeImmutable
     */
    public function dateUpdated(): DateTimeImmutable
    {
        return $this->dateUpdated;
    }

    /**
     * @return TeamMember
     */
    public function creator(): TeamMember
    {
        return $this->creator;
    }

    /**
     * @return TeamMemberCollection
     */
    public function assignees(): TeamMemberCollection
    {
        return $this->assignees;
    }

    /**
     * @return TagCollection
     */
    public function tags(): TagCollection
    {
        return $this->tags;
    }

    /**
     * @return bool
     */
    public function isSubTask(): bool
    {
        return !is_null($this->parentTaskId());
    }

    /**
     * @return string|null
     */
    public function parentTaskId(): ?string
    {
        return $this->parentTaskId;
    }

    /**
     * @throws GuzzleException
     *
     * @return Task|null
     */
    public function parentTask(): ?Task
    {
        if (is_null($this->parentTaskId())) {
            return null;
        }
        if (is_null($this->parentTask)) {
            $this->parentTask = $this
                ->tasks()
                ->getByTaskId($this->parentTaskId());
        }

        return $this->parentTask;
    }

    /**
     * @return int
     */
    public function priority(): int
    {
        return $this->priority;
    }

    /**
     * @return DateTimeImmutable
     */
    public function dueDate(): DateTimeImmutable
    {
        return $this->dueDate;
    }

    /**
     * @return DateTimeImmutable
     */
    public function startDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    /**
     * @return int
     */
    public function points(): int
    {
        return $this->points;
    }

    /**
     * @return string
     */
    public function timeEstimate(): string
    {
        return $this->timeEstimate;
    }

    /**
     * @return CustomFieldCollection
     */
    public function customFields(): CustomFieldCollection
    {
        return $this->customFields;
    }

    /**
     * @throws GuzzleException
     *
     * @return TaskList
     */
    public function taskList(): ?TaskList
    {
        if (is_null($this->taskList)) {
            $this->taskList = $this->folder()->taskList($this->taskListId());
        }

        return $this->taskList;
    }

    /**
     * @throws GuzzleException
     *
     * @return Folder
     */
    public function folder(): ?Folder
    {
        if (is_null($this->folder)) {
            $this->folder = $this->space()->folder($this->folderId());
        }

        return $this->folder;
    }

    /**
     * @throws GuzzleException
     *
     * @return Space
     */
    public function space(): ?Space
    {
        if (is_null($this->space)) {
            $this->space = $this->team()->space($this->spaceId());
        }

        return $this->space;
    }

    /**
     * @throws GuzzleException
     *
     * @return Team
     */
    public function team(): ?Team
    {
        if (is_null($this->team)) {
            $this->team = $this->client()->team($this->teamId());
        }

        return $this->team;
    }

    /**
     * @return int
     */
    public function teamId(): int
    {
        return $this->teamId;
    }

    /**
     * @return int
     */
    public function spaceId(): int
    {
        return $this->spaceId;
    }

    /**
     * @return int
     */
    public function folderId(): int
    {
        return $this->folderId;
    }

    /**
     * @return int
     */
    public function taskListId(): int
    {
        return $this->taskListId;
    }

    /**
     * @throws GuzzleException
     *
     * @return TaskCommentCollection|null
     */
    public function comment(): ?TaskCommentCollection
    {
        if (!is_null($this->comment)) {
            $this->comment = new TaskCommentCollection(
                $this,
                $this->client()->get("task/{$this->id()}/comment")['comments']
            );
        }

        return $this->comment;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @param $teamId
     */
    public function setTeamId($teamId)
    {
        $this->teamId = $teamId;
    }

    /**
     * @see https://jsapi.apiary.io/apis/clickup/reference/0/task/edit-task.html
     *
     * @param array $body
     *
     * @throws GuzzleException
     *
     * @return array
     */
    public function edit(array $body): array
    {
        return $this->client()->put("task/{$this->id()}", $body);
    }

    /**
     * @see https://jsapi.apiary.io/apis/clickup20/reference/0/custom-fields/set-custom-field-value.html
     *
     * @param string $customFieldId
     * @param array  $body
     *
     * @throws GuzzleException
     *
     * @return array|bool|float|int|object|string|null
     */
    public function setCustomField(string $customFieldId, array $body)
    {
        return $this->client()->post("task/{$this->id()}/field/{$customFieldId}", $body);
    }

    /**
     * @see https://jsapi.apiary.io/apis/clickup20/reference/0/tags/add-tag-to-task.html
     *
     * @param string $tagName
     *
     * @throws GuzzleException
     *
     * @return array|bool|float|int|object|string|null
     */
    public function setTag(string $tagName)
    {
        return $this->client()->post("task/{$this->id()}/tag/{$tagName}/");
    }

    /**
     * @param $array
     *
     * @throws Exception
     */
    protected function fromArray($array)
    {
        $this->id = $array['id'];
        $this->name = $array['name'];
        $this->description = (string) $array['text_content'];
        $this->status = new Status(
            $this->client(),
            $array['status']
        );
        $this->orderindex = $array['orderindex'];
        $this->dateCreated = $this->getDate($array, 'date_created');
        $this->dateUpdated = $this->getDate($array, 'date_updated');
        $this->creator = new User(
            $this->client(),
            $array['creator']
        );
        $this->assignees = new UserCollection(
            $this->client(),
            $array['assignees']
        );

        $this->parentTaskId = $array['parent'];
        $this->priority = $array['priority'];
        $this->dueDate = $this->getDate($array, 'due_date');
        $this->startDate = $this->getDate($array, 'start_date');
        $this->points = $array['point'] ?? null;
        $this->timeEstimate = $array['time_estimate'] ?? null;
        $this->taskListId = $array['list']['id'];
        $this->folderId = $array['folder']['id'];
        $this->spaceId = $array['space']['id'];
        $this->url = $array['url'];

        $this->tags = new TagCollection(
            $this->client(),
            $array['tags'] ?? []
        );
        $this->customFields = new CustomFieldCollection(
            $this->client(),
            $array['custom_fields'] ?? []
        );
    }
}
