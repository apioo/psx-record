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

/**
 * Record
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 *
 * @template T
 * @extends \PSX\Record\RecordAbstract<T>
 */
class Record extends RecordAbstract
{
    /**
     * @var array<string, T> 
     */
    private array $properties;

    /**
     * @param iterable<string, T> $properties
     */
    public function __construct(iterable $properties = [])
    {
        $this->properties = [];
        $this->merge($properties);
    }

    public function getProperties(): array
    {
        return array_filter($this->properties, function($value){
            return $value !== null;
        });
    }

    public function setProperties(array $properties): void
    {
        $this->properties = $properties;
    }

    /**
     * @param string $name
     * @return T
     */
    public function getProperty(string $name): mixed
    {
        return $this->properties[$name] ?? null;
    }

    /**
     * @param string $name
     * @param T $value
     */
    public function setProperty(string $name, mixed $value): void
    {
        $this->properties[$name] = $value;
    }

    public function removeProperty(string $name): void
    {
        if (isset($this->properties[$name])) {
            unset($this->properties[$name]);
        }
    }

    public function hasProperty(string $name): bool
    {
        return array_key_exists($name, $this->properties);
    }

    public function isEmpty(): bool
    {
        return count($this->properties) === 0;
    }

    public function merge(iterable $record): void
    {
        foreach ($record as $key => $value) {
            $this->setProperty($key, $value);
        }
    }

    public function filter(\Closure $filter): void
    {
        $this->properties = array_filter($this->properties, $filter);
    }

    public function map(\Closure $filter): void
    {
        $this->properties = array_map($filter, $this->properties);
    }

    public static function fromArray(iterable $data): static
    {
        return new static($data);
    }

    public static function fromStdClass(\stdClass $data): static
    {
        return new static(get_object_vars($data));
    }

    public static function from(iterable|\stdClass $data): static
    {
        if (is_iterable($data)) {
            return self::fromArray($data);
        } elseif ($data instanceof \stdClass) {
            return self::fromStdClass($data);
        } else {
            throw new \InvalidArgumentException('Can create record only from iterable or stdClass');
        }
    }

    public static function __set_state($array)
    {
        return new static($array['properties'] ?? []);
    }
}
