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

/**
 * Record
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 *
 * @template T
 * @implements \PSX\Record\RecordInterface<T>
 * @psalm-consistent-constructor
 */
class Record implements RecordInterface
{
    /**
     * @var array<string, T>
     */
    protected array $properties;

    /**
     * @param iterable<string, T> $properties
     */
    public function __construct(iterable $properties = [])
    {
        $this->properties = [];
        $this->putAll($properties);
    }

    public function clear(): void
    {
        $this->properties = [];
    }

    public function containsKey(string $key): bool
    {
        return array_key_exists($key, $this->properties);
    }

    public function containsValue(mixed $value): bool
    {
        return in_array($value, $this->properties, true);
    }

    public function filter(\Closure $filter): void
    {
        $this->properties = array_filter($this->properties, $filter);
    }

    public function forEach(\Closure $callback): void
    {
        foreach ($this->properties as $key => $value) {
            $callback($value, $key);
        }
    }

    /**
     * @return T|null
     */
    public function get(string $key): mixed
    {
        return $this->properties[$key] ?? null;
    }

    /**
     * @return array<string, T>
     */
    public function getAll(): array
    {
        return array_filter($this->properties, function($value){
            return $value !== null;
        });
    }

    /**
     * @return T|mixed
     */
    public function getOrDefault(string $key, mixed $default): mixed
    {
        return $this->properties[$key] ?? $default;
    }

    public function isEmpty(): bool
    {
        return count($this->properties) === 0;
    }

    public function keySet(): array
    {
        return array_keys($this->properties);
    }

    /**
     * @param T $value
     */
    public function put(string $key, mixed $value): void
    {
        $this->properties[$key] = $value;
    }

    /**
     * @param iterable<string, T> $record
     */
    public function putAll(iterable $record): void
    {
        foreach ($record as $key => $value) {
            $this->put($key, $value);
        }
    }

    public function putIfAbsent(string $key, mixed $value): mixed
    {
        if (!array_key_exists($key, $this->properties)) {
            $this->properties[$key] = $value;
            return null;
        } else {
            return $this->properties[$key];
        }
    }

    public function remove(string $key): void
    {
        if (isset($this->properties[$key])) {
            unset($this->properties[$key]);
        }
    }

    public function removeIfAvailable(string $key, mixed $value): bool
    {
        if (isset($this->properties[$key]) && $this->properties[$key] === $value) {
            unset($this->properties[$key]);
            return true;
        } else {
            return false;
        }
    }

    public function replace(string $key, mixed $value): void
    {
        if (isset($this->properties[$key])) {
            $this->properties[$key] = $value;
        }
    }

    public function replaceIfAvailable(string $key, mixed $value): bool
    {
        if (isset($this->properties[$key]) && $this->properties[$key] === $value) {
            $this->properties[$key] = $value;
            return true;
        } else {
            return false;
        }
    }

    public function replaceAll(\Closure $callback): void
    {
        foreach ($this->properties as $key => $value) {
            $this->properties[$key] = $callback($value, $key);
        }
    }

    public function size(): int
    {
        return count($this->properties);
    }

    public function values(): array
    {
        return array_values($this->properties);
    }

    /**
     * @param string $offset
     * @param T $value
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->put($offset, $value);
    }

    /**
     * @param string $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->containsKey($offset);
    }

    /**
     * @param string $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->remove($offset);
    }

    /**
     * @param string $offset
     * @return T
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * @return \Traversable<string, T>
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->getAll(), \ArrayIterator::ARRAY_AS_PROPS);
    }

    public function jsonSerialize(): object
    {
        return (object) $this->getAll();
    }

    public function __serialize()
    {
        return $this->getAll();
    }

    /**
     * @param array<string, mixed> $data
     */
    public function __unserialize(array $data)
    {
        $this->putAll($data);
    }

    /**
     * @param string $name
     * @param T $value
     */
    public function __set($name, $value)
    {
        $this->put($name, $value);
    }

    /**
     * @param string $name
     * @return T
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        return $this->containsKey($name);
    }

    /**
     * @param string $name
     */
    public function __unset($name)
    {
        $this->remove($name);
    }

    /**
     * @deprecated
     */
    public function getProperties(): array
    {
        return array_filter($this->properties, function($value){
            return $value !== null;
        });
    }

    /**
     * @deprecated
     */
    public function setProperties(array $properties): void
    {
        $this->properties = $properties;
    }

    /**
     * @deprecated
     * @param string $name
     * @return T
     */
    public function getProperty(string $name): mixed
    {
        return $this->properties[$name] ?? null;
    }

    /**
     * @deprecated
     * @param string $name
     * @param T $value
     */
    public function setProperty(string $name, mixed $value): void
    {
        $this->properties[$name] = $value;
    }

    /**
     * @deprecated
     */
    public function removeProperty(string $name): void
    {
        if (isset($this->properties[$name])) {
            unset($this->properties[$name]);
        }
    }

    /**
     * @deprecated
     */
    public function hasProperty(string $name): bool
    {
        return array_key_exists($name, $this->properties);
    }

    /**
     * @deprecated
     */
    public function merge(iterable $record): void
    {
        $this->putAll($record);
    }

    /**
     * @deprecated
     */
    public function map(\Closure $filter): void
    {
        $this->properties = array_map($filter, $this->properties);
    }

    /**
     * @psalm-suppress UnsafeGenericInstantiation
     */
    public static function fromIterable(iterable $data): static
    {
        return new static($data);
    }

    /**
     * @psalm-suppress UnsafeGenericInstantiation
     */
    public static function fromObject(object $data): static
    {
        return new static(get_object_vars($data));
    }

    /**
     * @psalm-suppress UnsafeGenericInstantiation
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }

    /**
     * @psalm-suppress UnsafeGenericInstantiation
     * @deprecated
     */
    public static function fromStdClass(\stdClass $data): static
    {
        return new static(get_object_vars($data));
    }

    public static function from(iterable|object $data): static
    {
        if (is_iterable($data)) {
            return self::fromIterable($data);
        } else {
            return self::fromObject($data);
        }
    }

    /**
     * @param array<string, mixed> $array
     */
    public static function __set_state($array)
    {
        return new static($array['properties'] ?? []);
    }
}
