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
 * ApiTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class ApiTest extends TestCase
{
    public function testClear()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertEquals(2, $record->size());
        $record->clear();
        $this->assertEquals(0, $record->size());
    }

    public function testContainsKey()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertTrue($record->containsKey('id'));
        $this->assertFalse($record->containsKey('foo'));
    }

    public function testContainsValue()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertTrue($record->containsValue(1));
        $this->assertFalse($record->containsValue('1'));
        $this->assertFalse($record->containsValue('foo'));
    }

    public function testFilter()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $record->filter(function($value){
            return $value !== 1;
        });

        $this->assertEquals(['title' => 'bar'], $record->getAll());
    }

    public function testForEach()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $list = [];
        $record->forEach(function($value) use (&$list) {
            $list[] = $value;
        });

        $this->assertEquals([1, 'bar'], $list);
    }

    public function testGet()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertEquals(1, $record->get('id'));
    }

    public function testGetAll()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertEquals(['id' => 1, 'title' => 'bar'], $record->getAll());
    }

    public function testGetOrDefault()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertEquals(1, $record->getOrDefault('id', false));
        $this->assertEquals(false, $record->getOrDefault('foo', false));
    }

    public function testIsEmpty()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertFalse($record->isEmpty());
        $record->clear();
        $this->assertTrue($record->isEmpty());
    }

    public function testKeySet()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertEquals(['id', 'title'], $record->keySet());
    }

    public function testPut()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $record->put('id', 2);
        $record->put('foo', 2);

        $this->assertEquals(['id' => 2, 'title' => 'bar', 'foo' => 2], $record->getAll());
    }

    public function testPutAll()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $record->putAll(['id' => 2, 'foo' => 2]);

        $this->assertEquals(['id' => 2, 'title' => 'bar', 'foo' => 2], $record->getAll());
    }

    public function testPutIfAbsent()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertEquals(1, $record->putIfAbsent('id', 2));
        $this->assertNull($record->putIfAbsent('foo', 2));
        $this->assertEquals(['id' => 1, 'title' => 'bar', 'foo' => 2], $record->getAll());
    }

    public function testRemove()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $record->remove('id');
        $record->remove('foo');

        $this->assertEquals(['title' => 'bar'], $record->getAll());
    }

    public function testRemoveIfAvailable()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $record->removeIfAvailable('id', 1);
        $record->removeIfAvailable('title', 1);
        $record->removeIfAvailable('foo', 1);

        $this->assertEquals(['title' => 'bar'], $record->getAll());
    }

    public function testReplace()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $record->replace('id', 2);
        $record->replace('foo', 1);

        $this->assertEquals(['id' => 2, 'title' => 'bar'], $record->getAll());
    }

    public function testReplaceIfAvailable()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $record->replaceIfAvailable('id', 1);
        $record->replaceIfAvailable('title', 'foo');
        $record->replaceIfAvailable('foo', 1);

        $this->assertEquals(['id' => 1, 'title' => 'bar'], $record->getAll());
    }

    public function testReplaceAll()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $record->replaceAll(function($value, $key){
            return $key === 'title' ? ucfirst($value) : $value;
        });

        $this->assertEquals(['id' => 1, 'title' => 'Bar'], $record->getAll());
    }

    public function testSize()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertEquals(2, $record->size());
    }

    public function testValues()
    {
        $record = new Record([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertEquals([1, 'bar'], $record->values());
    }
}
