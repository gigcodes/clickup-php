<?php

namespace ClickUp\Objects;

/**
 * Class TaskComment.
 */
class TaskComment extends Comment
{
    private Task $task;

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
    public function setTask(Task $task): void
    {
        $this->task = $task;
    }
}
