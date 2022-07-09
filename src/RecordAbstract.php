<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace PSX\Record;

use ArrayIterator;

/**
 * RecordAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 * 
 * @template T
 * @implements \PSX\Record\RecordInterface<T>
 */
abstract class RecordAbstract implements RecordInterface
{
    /**
     * @param string $offset
     * @param T $value
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->setProperty($offset, $value);
    }

    /**
     * @param string $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->hasProperty($offset);
    }

    /**
     * @param string $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->removeProperty($offset);
    }

    /**
     * @param string $offset
     * @return T
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->getProperty($offset);
    }

    /**
     * @return \Traversable<string, T>
     */
    public function getIterator(): \Traversable
    {
        return new ArrayIterator($this->getProperties(), ArrayIterator::ARRAY_AS_PROPS);
    }

    public function jsonSerialize(): object
    {
        return (object) $this->getProperties();
    }

    public function __serialize()
    {
        return $this->getProperties();
    }

    public function __unserialize(array $data)
    {
        $this->setProperties($data);
    }

    /**
     * @param string $name
     * @param T $value
     */
    public function __set($name, $value)
    {
        $this->setProperty($name, $value);
    }

    /**
     * @param string $name
     * @return T
     */
    public function __get($name)
    {
        return $this->getProperty($name);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        return $this->hasProperty($name);
    }

    /**
     * @param string $name
     */
    public function __unset($name)
    {
        $this->removeProperty($name);
    }
}
