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
 * MagicTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class MagicTest extends TestCase
{
    public function testOffsetSet()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertEquals(1, $record['id']);

        $record['id'] = 2;

        $this->assertEquals(2, $record['id']);
    }

    public function testOffsetExists()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertTrue(isset($record['id']));
    }

    public function testOffsetUnset()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertTrue(isset($record['id']));

        unset($record['id']);

        $this->assertFalse(isset($record['id']));
    }

    public function testGetMagicGetter()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertEquals(1, $record->id);
        $this->assertEquals('bar', $record->title);
    }

    public function testOffsetGet()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertEquals(1, $record['id']);
        $this->assertEquals('bar', $record['title']);
    }

    public function testSetMagicSetter()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertEquals(1, $record->id);
        $this->assertEquals('bar', $record->title);

        $record->id = 2;
        $record->title = 'foo';

        $this->assertEquals(2, $record->id);
        $this->assertEquals('foo', $record->title);
    }

    public function testSerialize()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertEquals(1, $record->id);
        $this->assertEquals('bar', $record->title);

        $record = unserialize(serialize($record));

        $this->assertEquals(1, $record->id);
        $this->assertEquals('bar', $record->title);
    }

    public function testJsonEncode()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $expect = '{"id": 1, "title": "bar"}';

        $this->assertJsonStringEqualsJsonString($expect, json_encode($record));
    }

    public function testJsonEncodeEmpty()
    {
        $record = new Record([]);

        $expect = '{}';

        $this->assertJsonStringEqualsJsonString($expect, json_encode($record));
    }

    public function testBadProperty()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $result = $record->foo;

        $this->assertNull($result);
    }

    public function testIterator()
    {
        $record = Record::fromArray(['id' => 1, 'foo' => 'bar']);

        $i = 0;
        foreach ($record as $key => $value) {
            if ($i === 0) {
                $this->assertEquals('id', $key);
                $this->assertEquals(1, $value);
            } elseif ($i === 1) {
                $this->assertEquals('foo', $key);
                $this->assertEquals('bar', $value);
            }

            $i++;
        }

        $this->assertEquals(2, $i);

        $actual = iterator_to_array($record->getIterator());
        $expect = ['id' => 1, 'foo' => 'bar'];

        $this->assertEquals($expect, $actual);
    }

    public function testIsset()
    {
        $record = Record::fromArray(['id' => 1, 'foo' => 'bar']);

        $this->assertTrue(isset($record->id));
        $this->assertFalse(isset($record->bar));
    }

    public function testUnset()
    {
        $record = Record::fromArray(['id' => 1, 'foo' => 'bar']);

        $this->assertTrue(isset($record->id));
        unset($record->id);
        $this->assertFalse(isset($record->id));
    }

    public function testSetState()
    {
        $oldRecord = new Record(['id' => 1, 'foo' => 'bar']);
        $newRecord = eval('return ' . var_export($oldRecord, true) . ';');

        $this->assertInstanceOf(RecordInterface::class, $newRecord);
        $this->assertEquals(['id' => 1, 'foo' => 'bar'], $newRecord->getProperties());
    }
}
