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
 * NamedConstructorTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class NamedConstructorTest extends TestCase
{
    public function testFromArray()
    {
        $record = Record::fromArray([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertInstanceOf(RecordInterface::class, $record);
        $this->assertEquals(1, $record->id);
        $this->assertEquals('bar', $record->title);
    }

    public function testFromStdClass()
    {
        $record = Record::fromStdClass((object)[
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertInstanceOf(RecordInterface::class, $record);
        $this->assertEquals(1, $record->id);
        $this->assertEquals('bar', $record->title);
    }

    public function testFromIterable()
    {
        $record = Record::fromIterable([
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertInstanceOf(RecordInterface::class, $record);
        $this->assertEquals(1, $record->id);
        $this->assertEquals('bar', $record->title);
    }

    public function testFromObject()
    {
        $record = Record::fromObject((object)[
            'id' => 1,
            'title' => 'bar',
        ]);

        $this->assertInstanceOf(RecordInterface::class, $record);
        $this->assertEquals(1, $record->id);
        $this->assertEquals('bar', $record->title);
    }

    public function testFrom()
    {
        $record = Record::from(['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], Record::from(['foo' => 'bar'])->getProperties());
        $this->assertEquals(['foo' => 'bar'], Record::from((object)['foo' => 'bar'])->getProperties());
        $this->assertEquals(['foo' => 'bar'], Record::from($record)->getProperties());
    }
}
