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

namespace PSX\Record\Tests;

use PSX\Record\Record;
use PSX\Record\RecordInterface;

/**
 * StoreTestCase
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
abstract class StoreTestCase extends \PHPUnit_Framework_TestCase
{
    public function testSaveLoad()
    {
        $store = $this->getStore();
        $store->save('foo', new Record('test', array('foo' => 'bar')));

        $record = $store->load('foo');

        $this->assertInstanceOf(RecordInterface::class, $record);
        $this->assertEquals('bar', $record->foo);
        $this->assertEquals(null, $store->load('bar'));
    }

    /**
     * @return \PSX\Record\StoreInterface
     */
    abstract public function getStore();
}
