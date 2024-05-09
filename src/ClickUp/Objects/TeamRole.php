<?php

namespace ClickUp\Objects;

/**
 * Class TeamRole.
 */
class TeamRole extends AbstractObject
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var bool */
    private $isCustom;

    /* @var Team $team */
    private $team;

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

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
    public function isCustom(): bool
    {
        return $this->isCustom;
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
     * @param $array
     */
    protected function fromArray($array)
    {
        $this->id = $array['id'] ?? false;
        $this->name = $array['name'] ?? false;
        $this->isCustom = $array['custom'] ?? false;
    }
}
