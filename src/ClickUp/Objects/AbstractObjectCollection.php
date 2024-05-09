<?php

namespace ClickUp\Objects;

use ArrayIterator;
use IteratorAggregate;
use RuntimeException;
use Traversable;

/**
 * Class AbstractObjectCollection
 */
abstract class AbstractObjectCollection extends AbstractObject implements IteratorAggregate
{
    protected array $objects = [];

    /**
     * Get an object by its key (ID)
     *
     * @param string $id
     * @return AbstractObject
     * @throws RuntimeException if the object with the given ID does not exist
     */
    public function getByKey(string $id): AbstractObject
    {
        return $this->objects[$id] ?? throw new RuntimeException("id:$id not exist.");
    }

    /**
     * Get an object by its name
     *
     * @param string $name
     * @return AbstractObject
     * @throws RuntimeException if the object with the given name does not exist
     */
    public function getByName(string $name): AbstractObject
    {
        $nameKey = $this->nameKey();
        foreach ($this as $value) {
            if ($name === $value->$nameKey()) {
                return $value;
            }
        }

        throw new RuntimeException("name:$name not exist.");
    }

    /**
     * The name key to use for comparisons
     */
    protected function nameKey(): string
    {
        return 'name';
    }

    /**
     * Return an iterator over the collection
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->objects());
    }

    /**
     * Get all objects in the collection
     *
     * @return AbstractObject[]
     */
    public function objects(): array
    {
        return $this->objects;
    }

    /**
     * Check if the collection is not empty
     */
    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * Check if the collection is empty
     */
    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /**
     * Get the count of objects in the collection
     */
    public function count(): int
    {
        return count($this->objects);
    }

    /**
     * Populate the collection from an array
     */
    protected function fromArray($array): void
    {
        $class = $this->objectClass();
        foreach ($array as $value) {
            $this->objects[$value[$this->key()]] = new $class(
                $this->client(),
                $value
            );
        }
    }

    /**
     * Return the fully-qualified class name of the objects in this collection
     */
    abstract protected function objectClass(): string;

    /**
     * The key to use when indexing the objects
     */
    protected function key(): string
    {
        return 'id';
    }
}
