<?php

namespace ClickUp\Objects;

use ClickUp\Traits\TaskFinderTrait;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class Space.
 */
class Space extends AbstractObject
{
    use TaskFinderTrait;

    /* @var int $id */
    private $id;

    /* @var string $name */
    private $name;

    /* @var bool $isPrivate */
    private $isPrivate;

    /* @var StatusCollection $statuses */
    private $statuses;

    /* @var array $clickApps */
    private $clickApps;

    /* @var int|null $teamId */
    private $teamId;

    /* @var Team $team */
    private $team;

    /* @var FolderCollection|null $folders */
    private $folders = null;

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isPrivate(): bool
    {
        return $this->isPrivate;
    }

    /**
     * @return StatusCollection
     */
    public function statuses(): StatusCollection
    {
        return $this->statuses;
    }

    /**
     * @return array
     */
    public function clickApps(): array
    {
        return $this->clickApps;
    }

    /**
     * @param $folderId
     *
     * @throws GuzzleException
     *
     * @return Folder
     */
    public function folder($folderId): Folder
    {
        return $this->folders()->getByKey($folderId);
    }

    /**
     * @throws GuzzleException
     *
     * @return FolderCollection
     */
    public function folders(): ?FolderCollection
    {
        if (is_null($this->folders)) {
            $this->folders = new FolderCollection(
                $this,
                $this->client()->get("space/{$this->id()}/folder")['folders']
            );
        }

        return $this->folders;
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @param Team $team
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @return int
     */
    public function teamId(): int
    {
        return $this->team()->id();
    }

    /**
     * Access parent class.
     *
     * @return Team
     */
    public function team(): Team
    {
        return $this->team;
    }

    /**
     * @return array
     */
    protected function taskFindParams(): array
    {
        return ['space_ids' => [$this->id()]];
    }

    /**
     * @param array $array
     */
    protected function fromArray($array)
    {
        $this->id = $array['id'];
        $this->name = $array['name'];
        $this->isPrivate = $array['private'];
        $this->statuses = new StatusCollection($this->client(), $array['statuses']);
        $this->clickApps = [
            'multiple_assignees' => $array['multiple_assignees'] ?? false,
            'due_dates'          => $array['features']['due_dates']['enabled'] ?? false,
            'time_tracking'      => $array['features']['time_tracking']['enabled'] ?? false,
            'tags'               => $array['features']['tags']['enabled'] ?? false,
            'time_estimates'     => $array['features']['time_estimates']['enabled'] ?? false,
            'checklists'         => $array['features']['checklists']['enabled'] ?? false,
            'custom_fields'      => $array['features']['custom_fields']['enabled'] ?? false,
            'remap_dependencies' => $array['features']['remap_dependencies']['enabled'] ?? false,
            'dependency_warning' => $array['features']['dependency_warning']['enabled'] ?? false,
            'portfolios'         => $array['features']['portfolios']['enabled'] ?? false,
        ];
    }
}
