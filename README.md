
# Record

## About

This package provides a simple to use record implementation which represents a
HashMap. The following example show how to use the record class:

```php
<?php

use PSX\Record\Mapper;
use PSX\Record\Merger;
use PSX\Record\Record;

$record = new Record();
$record->setProperty('foo', 'bar');

$record->getProperty('foo'); // method access
$record->foo; // property access
$record['foo']; // array access

\json_encode($record); // results in {"foo": "bar"}

$record = Record::fromArray(['foo' => 'bar']); // create a record from an array

$record = unserialize(serialize($record)); // a record is serializable

// merge two records
Merger::merge($record, Record::fromArray(['bar' => 'foo']));

// map data from an record to a POPO using setter
Mapper::map($record, new MyPopo());

```
