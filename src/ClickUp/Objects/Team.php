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
    private int $id;
    private string $name;
    private string $color;
    private ?string $avatar;
    private TeamMemberCollection $members;
    private TeamRoleCollection $roles;
    private ?SpaceCollection $spaces = null;

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
     * @param int $spaceId
     *
     * @return Space
     * @throws GuzzleException
     */
    public function space(int $spaceId): Space
    {
        return $this->spaces()->getByKey($spaceId);
    }

    /**
     * @return SpaceCollection|null
     * @throws GuzzleException
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
    protected function fromArray($array): void
    {
        $this->id = $array['id'];
        $this->name = $array['name'];
        $this->color = $array['color'];
        $this->avatar = $array['avatar'];
        $this->members = new TeamMemberCollection($this, $array['members']);
        $this->roles = new TeamRoleCollection($this, $array['roles'] ?? []);
    }
}
