<?php

namespace ClickUp\Objects;

use ArrayIterator;
use IteratorAggregate;
use RuntimeException;
use Traversable;

/**
 * Class AbstractObjectCollection.
 */
abstract class AbstractObjectCollection extends AbstractObject implements IteratorAggregate
{
    /* @var AbstractObject[] $objects */
    protected $objects;

    /**
     * @param string $id
     *
     * @return AbstractObject
     */
    public function getByKey(string $id): AbstractObject
    {
        if (!isset($this->objects[$id])) {
            throw new RuntimeException("id:$id not exist.");
        }

        return $this->objects[$id];
    }

    /**
     * @param string $name
     *
     * @return AbstractObject
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
     * @return string
     */
    protected function nameKey(): string
    {
        return 'name';
    }

    /**
     * @return ArrayIterator|Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->objects());
    }

    /**
     * @return AbstractObject[]
     */
    public function objects(): array
    {
        return $this->objects;
    }

    /**
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->count() == 0;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->objects);
    }

    /**
     * @param array $array
     */
    protected function fromArray($array)
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
     * @return string
     */
    abstract protected function objectClass(): string;

    /**
     * @return string
     */
    protected function key(): string
    {
        return 'id';
    }
}
