<?php

namespace ClickUp\Objects;

/**
 * @method TeamMember   getByKey(int $id)
 * @method TeamMember   getByName(string $name)
 * @method TeamMember[] objects()
 * @method TeamMember[] getIterator()
 */
class TeamMemberCollection extends UserCollection
{
    public function __construct(Team $team, $array)
    {
        parent::__construct($team->client(), $array);
        $this->setTeam($team);
    }

    private function setTeam(Team $team)
    {
        foreach ($this as $teamMember) {
            $teamMember->setTeam($team);
        }
    }

    /**
     * @return string
     */
    protected function objectClass(): string
    {
        return TeamMember::class;
    }

    /**
     * @param array $array
     */
    protected function fromArray($array)
    {
        foreach ($array as $key => $value) {
            $array[$key] = $value['user'];
        }
        parent::fromArray($array);
    }
}
