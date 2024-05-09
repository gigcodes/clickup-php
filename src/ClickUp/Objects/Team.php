<?php

namespace ClickUp\Objects;

use ClickUp\Traits\TaskFinderTrait;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class Team.
 */
class Team extends AbstractObject
{
    use TaskFinderTrait;

    /* @var int $id */
    private $id;

    /* @var string $name */
    private $name;

    /* @var string $color */
    private $color;

    /* @var string $avatar */
    private $avatar;

    /* @var TeamMemberCollection $members */
    private $members;

    /* @var TeamRoleCollection $roles */
    private $roles;

    /* @var SpaceCollection|null $spaces */
    private $spaces = null;

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
    public function color(): string
    {
        return $this->color;
    }

    /**
     * @return string
     */
    public function avatar(): string
    {
        return $this->avatar;
    }

    /**
     * @return TeamMemberCollection
     */
    public function members(): TeamMemberCollection
    {
        return $this->members;
    }

    /**
     * @param $spaceId
     *
     * @throws GuzzleException
     *
     * @return Space
     */
    public function space($spaceId): Space
    {
        return $this->spaces()->getByKey($spaceId);
    }

    /**
     * @throws GuzzleException
     *
     * @return SpaceCollection
     */
    public function spaces(): ?SpaceCollection
    {
        if (is_null($this->spaces)) {
            $this->spaces = new SpaceCollection(
                $this,
                $this->client()->get("team/{$this->id()}/space")['spaces']
            );
        }

        return $this->spaces;
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
        return $this->id();
    }

    /**
     * @param array $array
     */
    protected function fromArray($array)
    {
        $this->id = $array['id'];
        $this->name = $array['name'];
        $this->color = $array['color'];
        $this->avatar = $array['avatar'];
        $this->members = new TeamMemberCollection($this, $array['members']);
        $this->roles = new TeamRoleCollection($this, $array['roles'] ?? []);
    }
}
