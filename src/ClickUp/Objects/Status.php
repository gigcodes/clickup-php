<?php

namespace ClickUp\Objects;

/**
 * Class Status.
 */
class Status extends AbstractObject
{
    private int $id;
    private string $name;
    private string $color;
    private string $type;
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
     * @return string
     */
    public function color(): string
    {
        return $this->color;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @param array $array
     */
    protected function fromArray($array): void
    {
        $this->id = $array['orderindex'];
        $this->name = $array['status'];
        $this->color = $array['color'];
        $this->type = $array['type'];
    }
}
