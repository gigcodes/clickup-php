<?php

namespace ClickUp\Objects;

/**
 * @method Folder   getByKey(int $id)
 * @method Folder   getByName(string $name)
 * @method Folder[] objects()
 * @method Folder[] getIterator()
 */
class FolderCollection extends AbstractObjectCollection
{
    public function __construct(Space $space, $array)
    {
        parent::__construct($space->client(), $array);
        foreach ($this as $folder) {
            $folder->setSpace($space);
            if ($folder->overrideStatuses() === false) {
                $folder->setStatuses($space->statuses());
            }
        }
    }

    /**
     * @return string
     */
    protected function objectClass(): string
    {
        return Folder::class;
    }
}
