<?php

namespace ClickUp\Objects;

use ClickUp\Traits\DateImmutableTrait;
use DateTimeImmutable;
use Exception;

/**
 * Class Comment
 */
class Comment extends AbstractObject
{
    use DateImmutableTrait;

    private string $id;
    private string $commentText;
    private ?User $user;
    private bool $isResolved;
    private DateTimeImmutable $date;

    /**
     * Get the ID of the comment
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * Get the text of the comment
     */
    public function commentText(): string
    {
        return $this->commentText;
    }

    /**
     * Get the user who made the comment
     */
    public function user(): ?User
    {
        return $this->user;
    }

    /**
     * Get the date of the comment
     */
    public function date(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * Check if the comment is resolved
     */
    public function isResolved(): bool
    {
        return $this->isResolved;
    }

    /**
     * Populate the comment object from an array
     *
     * @param array $array
     * @throws Exception
     */
    protected function fromArray($array): void
    {
        $this->id = $array['id'] ?? throw new Exception('Missing required field: id');
        $this->commentText = $array['comment_text'] ?? throw new Exception('Missing required field: comment_text');
        $this->user = isset($array['user']) ? new User($this->client(), $array['user']) : null;
        $this->isResolved = $array['resolved'] ?? false;
        $this->date = $this->getDate($array, 'date') ?? throw new Exception('Missing required field: date');
    }
}
