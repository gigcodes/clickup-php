<?php

namespace ClickUp\Objects;

/**
 * Class CustomField.
 */
class CustomField extends AbstractObject
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $type;

    /** @var bool */
    private $isHideFromGuests;

    /** @var mixed */
    private $value;

    /** @var bool */
    private $isRequired;

    /**
     * @return string
     */
    public function id(): string
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
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isHideFromGuests(): bool
    {
        return $this->isHideFromGuests;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->isRequired;
    }

    /**
     * @param $array
     */
    protected function fromArray($array)
    {
        $this->id = $array['id'] ?? false;
        $this->name = $array['name'] ?? false;
        $this->type = $array['type'] ?? false;
        $this->isHideFromGuests = $array['hide_from_guests'] ?? false;
        $this->value = $array['value'] ?? false;
        $this->isRequired = $array['required'] ?? false;
    }
}
