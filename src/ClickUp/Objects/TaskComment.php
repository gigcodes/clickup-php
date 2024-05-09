<?php

namespace ClickUp\Objects;

/**
 * Class TaskComment.
 */
class TaskComment extends Comment
{
    /** @var Task */
    private $task;

    /**
     * @return Task
     */
    public function task(): Task
    {
        return $this->task;
    }

    /**
     * @param Task $task
     */
    public function setTask(Task $task)
    {
        $this->task = $task;
    }
}
