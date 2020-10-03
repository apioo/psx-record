<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * @link    http://phpsx.org
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
    public function offsetSet($offset, $value)
    {
        $this->setProperty($offset, $value);
    }

    /**
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->hasProperty($offset);
    }

    /**
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        $this->removeProperty($offset);
    }

    /**
     * @param string $offset
     * @return T
     */
    public function offsetGet($offset)
    {
        return $this->getProperty($offset);
    }

    /**
     * @return \Traversable<string, T>
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getProperties(), ArrayIterator::ARRAY_AS_PROPS);
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize($this->getProperties());
    }

    /**
     * @param string $data
     */
    public function unserialize($data)
    {
        $this->setProperties(unserialize($data));
    }

    /**
     * @return object
     */
    public function jsonSerialize()
    {
        return (object) $this->getProperties();
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
