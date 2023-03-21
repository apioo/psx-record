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

namespace PSX\Record\Tests;

use PHPUnit\Framework\TestCase;
use PSX\Record\Record;
use PSX\Record\RecordInterface;

/**
 * LegacyTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class LegacyTest extends TestCase
{
    public function testGetProperty()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertEquals(1, $record->getProperty('id'));
        $this->assertEquals('bar', $record->getProperty('title'));
    }

    public function testSetProperty()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertEquals(1, $record->getProperty('id'));

        $record->setProperty('id', 2);

        $this->assertEquals(2, $record->getProperty('id'));
    }

    public function testRemoveProperty()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertTrue($record->hasProperty('id'));

        $record->removeProperty('id');

        $this->assertFalse($record->hasProperty('id'));
    }

    public function testHasProperty()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertTrue($record->hasProperty('id'));
    }

    public function testIsEmpty()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertTrue($record->hasProperty('id'));
    }

    public function testMerge()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $record->merge(['foo' => 'bar']);
        $record->merge(Record::fromArray(['bar' => 'bar']));

        $this->assertTrue($record->hasProperty('id'));
    }

    public function testGetProperties()
    {
        $fields = [
            'id' => 1,
            'title' => 'bar',
        ];
        $record = new Record($fields);

        $this->assertEquals($fields, $record->getProperties());
    }

    public function testFilter()
    {
        $fields = [
            'id' => 1,
            'title' => 'bar',
        ];
        $record = new Record($fields);
        $record->filter(function ($value) {
            return $value !== 1;
        });

        $this->assertEquals(['title' => 'bar'], $record->getProperties());
    }

    public function testMap()
    {
        $fields = [
            'id' => 1,
            'title' => 'bar',
        ];
        $record = new Record($fields);
        $record->map(function ($value) {
            return strtoupper($value);
        });

        $this->assertEquals(['id' => 1, 'title' => 'BAR'], $record->getProperties());
    }
}
