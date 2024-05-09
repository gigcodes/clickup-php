<?php

namespace ClickUp\Objects;

/**
 * @method TeamRole   getByKey(int $id)
 * @method TeamRole   getByName(string $name)
 * @method TeamRole[] objects()
 * @method TeamRole[] getIterator()
 */
class TeamRoleCollection extends AbstractObjectCollection
{
    /**
     * TeamRoleCollection constructor.
     *
     * @param Team $team
     * @param $array
     */
    public function __construct(Team $team, $array)
    {
        parent::__construct($team->client(), $array);
        $this->setTeam($team);
    }

    /**
     * @param Team $team
     */
    private function setTeam(Team $team)
    {
        foreach ($this as $teamRole) {
            $teamRole->setTeam($team);
        }
    }

    /**
     * @inheritDoc
     */
    protected function objectClass(): string
    {
        return TeamRole::class;
    }
}
