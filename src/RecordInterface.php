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

use ArrayAccess;
use IteratorAggregate;
use JsonSerializable;
use Serializable;

/**
 * RecordInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 * 
 * @template T
 * @implements \ArrayAccess<string, T>
 * @implements \IteratorAggregate<string, T>
 */
interface RecordInterface extends ArrayAccess, Serializable, JsonSerializable, IteratorAggregate
{
    /**
     * Returns all properties which are set
     *
     * @return array<string, T>
     */
    public function getProperties(): array;

    /**
     * Sets the available properties
     *
     * @param array<string, T> $properties
     * @return void
     */
    public function setProperties(array $properties): void;

    /**
     * Returns a property
     *
     * @param string $name
     * @return T|null
     */
    public function getProperty(string $name);

    /**
     * Sets a property
     *
     * @param string $name
     * @param T $value
     * @return void
     */
    public function setProperty(string $name, $value): void;

    /**
     * Removes a property
     *
     * @param string $name
     * @return void
     */
    public function removeProperty(string $name): void;

    /**
     * Returns whether a property exist
     *
     * @param string $name
     * @return boolean
     */
    public function hasProperty(string $name): bool;

    /**
     * Returns whether the record is empty
     * 
     * @return boolean
     */
    public function isEmpty(): bool;

    /**
     * Iterates through all entries and adds them to the record
     * 
     * @param iterable<string, T> $record
     */
    public function merge(iterable $record): void;

    /**
     * Filters specific entries out of the map
     * 
     * @param \Closure $filter
     */
    public function filter(\Closure $filter): void;

    /**
     * Applies a callback on each value of the map
     * 
     * @param \Closure $filter
     */
    public function map(\Closure $filter): void;
}
