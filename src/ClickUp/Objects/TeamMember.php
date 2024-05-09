<?php

namespace ClickUp\Objects;

/**
 * Class TeamMember.
 */
class TeamMember extends User
{
    /* @var int $role */
    private $role;

    /* @var Team $team */
    private $team;

    /**
     * @return int
     */
    public function role(): int
    {
        return $this->role;
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
     * @param Team $team
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @param array $array
     */
    public function fromArray($array)
    {
        $this->role = $array['role'];
        parent::fromArray($array);
    }
}
