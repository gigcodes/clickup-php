<?php

namespace ClickUp\Objects;

/**
 * Class TeamRole.
 */
class TeamRole extends AbstractObject
{
    private int $id;
    private string $name;
    private bool $isCustom;
    private Team $team;

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
    public function setTeam(Team $team): void
    {
        $this->team = $team;
    }

    /**
     * @param array $array
     */
    protected function fromArray($array): void
    {
        $this->id = $array['id'] ?? false;
        $this->name = $array['name'] ?? false;
        $this->isCustom = $array['custom'] ?? false;
    }
}
