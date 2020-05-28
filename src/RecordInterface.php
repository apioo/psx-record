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
     * Returns the display name of the object
     *
     * @return string
     */
    public function getDisplayName();

    /**
     * Sets the display name
     *
     * @param string $displayName
     * @return void
     */
    public function setDisplayName($displayName);

    /**
     * Returns all properties which are set
     *
     * @return array<string, T>
     */
    public function getProperties();

    /**
     * Sets the available properties
     *
     * @param array<string, T> $properties
     * @return void
     */
    public function setProperties(array $properties);

    /**
     * Returns a property
     *
     * @param string $name
     * @return T|null
     */
    public function getProperty($name);

    /**
     * Sets a property
     *
     * @param string $name
     * @param T $value
     * @return void
     */
    public function setProperty($name, $value);

    /**
     * Removes a property
     *
     * @param string $name
     * @return void
     */
    public function removeProperty($name);

    /**
     * Returns whether a property exist
     *
     * @param string $name
     * @return boolean
     */
    public function hasProperty($name);
}
