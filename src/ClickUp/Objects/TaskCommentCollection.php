<?php

namespace ClickUp\Objects;

/**
 * @method TaskComment   getByKey(int $id)
 * @method TaskComment[] objects()
 * @method TaskComment[] getIterator()
 */
class TaskCommentCollection extends CommentCollection
{
    /**
     * TaskCommentCollection constructor.
     *
     * @param Task $task
     * @param $array
     */
    public function __construct(Task $task, $array)
    {
        parent::__construct($task->client(), $array);
        foreach ($this as $taskComment) {
            $taskComment->setTask($task);
        }
    }

    /**
     * @return string
     */
    protected function objectClass(): string
    {
        return TaskComment::class;
    }
}
