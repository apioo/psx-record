<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2018 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * @link    http://phpsx.org
 *
 * @template T
 * @extends \PSX\Record\RecordAbstract<T>
 */
class Record extends RecordAbstract
{
    /**
     * @var array<string, T> 
     */
    private $properties;

    /**
     * @param array<string, T> $properties
     */
    public function __construct(iterable $properties = [])
    {
        $this->properties = [];
        $this->merge($properties);
    }

    /**
     * @inheritDoc
     */
    public function getProperties(): array
    {
        return array_filter($this->properties, function($value){
            return $value !== null;
        });
    }

    /**
     * @inheritDoc
     */
    public function setProperties(array $properties): void
    {
        $this->properties = $properties;
    }

    /**
     * @inheritDoc
     */
    public function getProperty(string $name)
    {
        return isset($this->properties[$name]) ? $this->properties[$name] : null;
    }

    /**
     * @inheritDoc
     */
    public function setProperty(string $name, $value): void
    {
        $this->properties[$name] = $value;
    }

    /**
     * @inheritDoc
     */
    public function removeProperty(string $name): void
    {
        if (isset($this->properties[$name])) {
            unset($this->properties[$name]);
        }
    }

    /**
     * @inheritDoc
     */
    public function hasProperty(string $name): bool
    {
        return array_key_exists($name, $this->properties);
    }

    /**
     * @inheritDoc
     */
    public function isEmpty(): bool
    {
        return count($this->properties) === 0;
    }

    /**
     * @param iterable $record
     */
    public function merge(iterable $record): void
    {
        foreach ($record as $key => $value) {
            $this->setProperty($key, $value);
        }
    }

    /**
     * @param \Closure $filter
     */
    public function filter(\Closure $filter): void
    {
        $this->properties = array_filter($this->properties, $filter);
    }

    /**
     * @param \Closure $filter
     */
    public function map(\Closure $filter): void
    {
        $this->properties = array_map($filter, $this->properties);
    }

    /**
     * @param iterable $data
     * @return \PSX\Record\RecordInterface
     */
    public static function fromArray(iterable $data): RecordInterface
    {
        return new static($data);
    }

    /**
     * @param \stdClass $data
     * @return \PSX\Record\RecordInterface
     */
    public static function fromStdClass(\stdClass $data): RecordInterface
    {
        return new static((array) $data);
    }

    /**
     * @param iterable|\stdClass $data
     * @return \PSX\Record\RecordInterface
     */
    public static function from($data): RecordInterface
    {
        if (is_iterable($data)) {
            return self::fromArray($data);
        } elseif ($data instanceof \stdClass) {
            return self::fromStdClass($data);
        } else {
            throw new \InvalidArgumentException('Can create record only from iterable or stdClass');
        }
    }

    /**
     * @param array $array
     * @return \PSX\Record\RecordInterface
     */
    public static function __set_state($array)
    {
        return new static($array['properties'] ?? []);
    }
}
