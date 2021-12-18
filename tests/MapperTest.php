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

namespace PSX\Record\Tests;

use PHPUnit\Framework\TestCase;
use PSX\Record\Record;
use PSX\Record\Mapper;
use PSX\Record\Mapper\Rule;

/**
 * MapperTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class MapperTest extends TestCase
{
    public function testMap()
    {
        $source = Record::fromArray([
            'id' => 1,
            // userId is not available in the source
            'userId' => 12,
            // underscore names are converted to camelcase
            'right_level' => 'bar',
            'title' => 'foo',
            'content' => 'bar',
            'rating' => 'a-rating',
            'date' => '2014-09-06',
        ]);

        $destination = new \PSX\Record\Tests\Mapper\Destination();
        $testCase    = $this;

        Mapper::map($source, $destination, array(
            'title'   => 'description',
            'content' => new Rule('content'),
            'rating'  => new Rule('level', 'no-rating'),
            'date'    => new Rule('date', function ($value) use ($testCase) {
                $testCase->assertEquals('2014-09-06', $value);

                return strtotime($value);
            }),
        ));

        $this->assertEquals($source->id, $destination->getId());
        $this->assertEquals($source->right_level, $destination->getRightLevel());
        $this->assertEquals($source->title, $destination->getDescription());
        $this->assertEquals($source->content, $destination->getContent());
        $this->assertEquals('no-rating', $destination->getLevel());
        $this->assertEquals('1409961600', $destination->getDate());
    }
}
