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

use ArrayAccess;
use IteratorAggregate;
use JsonSerializable;
use Serializable;

/**
 * RecordInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 * 
 * @template T
 * @implements \ArrayAccess<string, T>
 * @implements \IteratorAggregate<string, T>
 */
interface RecordInterface extends ArrayAccess, JsonSerializable, IteratorAggregate
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
    public function setProperty(string $name, mixed $value): void;

    /**
     * Removes a property
     */
    public function removeProperty(string $name): void;

    /**
     * Returns whether a property exist
     */
    public function hasProperty(string $name): bool;

    /**
     * Returns whether the record is empty
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
     */
    public function filter(\Closure $filter): void;

    /**
     * Applies a callback on each value of the map
     */
    public function map(\Closure $filter): void;
}
