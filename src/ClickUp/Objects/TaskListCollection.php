<?php

namespace ClickUp\Objects;

/**
 * @method TaskList   getByKey(int $id)
 * @method TaskList   getByName(string $name)
 * @method TaskList[] objects()
 * @method TaskList[] getIterator()
 */
class TaskListCollection extends AbstractObjectCollection
{
    public function __construct(Folder $folder, $array)
    {
        parent::__construct($folder->client(), $array);
        foreach ($this as $taskList) {
            $taskList->setFolder($folder);
        }
    }

    /**
     * @return string
     */
    protected function objectClass(): string
    {
        return TaskList::class;
    }
}
