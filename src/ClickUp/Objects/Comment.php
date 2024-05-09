<?php

namespace ClickUp\Objects;

use ClickUp\Traits\DateImmutableTrait;
use DateTimeImmutable;
use Exception;

/**
 * Class Comment.
 */
class Comment extends AbstractObject
{
    use DateImmutableTrait;

    /** @var string */
    private string $id;

    /** @var string */
    private string $commentText;

    /** @var User */
    private User $user;

    /** @var bool */
    private bool $isResolved;

    /** @var DateTimeImmutable */
    private DateTimeImmutable $date;

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
    public function commentText(): string
    {
        return $this->commentText;
    }

    /**
     * @return User
     */
    public function user(): User
    {
        return $this->user;
    }

    /**
     * @return DateTimeImmutable
     */
    public function date(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return bool
     */
    public function isResolved(): bool
    {
        return $this->isResolved;
    }

    /**
     * @param $array
     *
     * @throws Exception
     */
    protected function fromArray($array): void
    {
        $this->id = $array['id'] ?? false;
        $this->commentText = $array['comment_text'] ?? false;
        $this->user = isset($array['user']) ? new User($this->client(), $array['user']) : false;
        $this->isResolved = $array['resolved'] ?? false;
        $this->date = isset($array['date']) ? $this->getDate($array, 'date') : false;
    }
}
