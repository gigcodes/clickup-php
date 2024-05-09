<?php

namespace ClickUp\Objects;

/**
 * Class TeamMember.
 */
class TeamMember extends User
{
    private int $role;
    private Team $team;

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
    public function setTeam(Team $team): void
    {
        $this->team = $team;
    }

    /**
     * @param array $array
     */
    public function fromArray($array):void
    {
        $this->role = $array['role'];
        parent::fromArray($array);
    }
}
