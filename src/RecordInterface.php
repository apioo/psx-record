<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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
     * Removes all of the mappings from this map
     */
    public function clear(): void;

    /**
     * Returns true if this map contains a mapping for the specified key
     */
    public function containsKey(string $key): bool;

    /**
     * Returns true if this map maps one or more keys to the specified value
     */
    public function containsValue(mixed $value): bool;

    /**
     * Filters specific entries out of the map
     */
    public function filter(\Closure $filter): void;

    /**
     * Performs the given action for each entry in this map until all entries have been processed or the action throws an exception
     */
    public function forEach(\Closure $callback): void;

    /**
     * Returns the value to which the specified key is mapped, or null if this map contains no mapping for the key
     *
     * @return T|null
     */
    public function get(string $key): mixed;

    /**
     * Returns all values as array
     */
    public function getAll(): array;

    /**
     * Returns the value to which the specified key is mapped, or defaultValue if this map contains no mapping for the
     * key
     *
     * @return T|mixed
     */
    public function getOrDefault(string $key, mixed $default): mixed;

    /**
     * Returns whether the record is empty
     */
    public function isEmpty(): bool;

    /**
     * Returns an array view of the keys contained in this map
     */
    public function keySet(): array;

    /**
     * Associates the specified value with the specified key in this map
     *
     * @param T $value
     */
    public function put(string $key, mixed $value): void;

    /**
     * Copies all of the mappings from the specified map to this map
     *
     * @param iterable<string, T> $record
     */
    public function putAll(iterable $record): void;

    /**
     * If the specified key is not already associated with a value (or is mapped to null) associates it with the given
     * value and returns null, else returns the current value
     */
    public function putIfAbsent(string $key, mixed $value): mixed;

    /**
     * Removes the mapping for the specified key from this map if present
     */
    public function remove(string $key): void;

    /**
     * Removes the entry for the specified key only if it is currently mapped to the specified value
     */
    public function removeIfAvailable(string $key, mixed $value): bool;

    /**
     * Replaces the entry for the specified key only if it is currently mapped to some value
     */
    public function replace(string $key, mixed $value): void;

    /**
     * Replaces the entry for the specified key only if currently mapped to the specified value
     */
    public function replaceIfAvailable(string $key, mixed $value): bool;

    /**
     * Replaces each entry's value with the result of invoking the given function on that entry until all entries have
     * been processed or the function throws an exception
     */
    public function replaceAll(\Closure $callback): void;

    /**
     * Returns the number of key-value mappings in this map
     */
    public function size(): int;

    /**
     * Returns an array view of the values contained in this map
     */
    public function values(): array;
}
