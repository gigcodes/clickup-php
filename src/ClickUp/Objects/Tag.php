<?php

namespace ClickUp\Objects;

/**
 * Class Tag.
 */
class Tag extends AbstractObject
{
    /** @var string */
    private $name;

    /** @var string */
    private $tag_fg;

    /** @var string */
    private $tag_bg;

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
    public function tagFg(): string
    {
        return $this->tag_fg;
    }

    /**
     * @return string
     */
    public function tagBg(): string
    {
        return $this->tag_bg;
    }

    protected function fromArray($array)
    {
        $this->name = $array['name'] ?? false;
        $this->tag_fg = $array['tag_fg'] ?? false;
        $this->tag_bg = $array['tag_bg'] ?? false;
    }
}
