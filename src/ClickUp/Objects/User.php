<?php

namespace ClickUp\Objects;

/**
 * Class User.
 */
class User extends AbstractObject
{
    private int $id;
    private string $username;
    private string $color;
    private string $profilePicture;
    private string|null $initials = null;

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
    public function username(): string
    {
        return $this->username;
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
    public function profilePicture(): string
    {
        return $this->profilePicture;
    }

    /**
     * @return string|null
     */
    public function initials(): ?string
    {
        return $this->initials;
    }

    /**
     * @param array $array
     */
    protected function fromArray($array): void
    {
        $this->id = $array['id'];
        $this->username = $array['username'];
        $this->color = $array['color'];
        $this->profilePicture = $array['profilePicture'];
        $this->initials = $array['initials'] ?? null;
    }
}
