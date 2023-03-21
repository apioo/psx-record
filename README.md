
# Record

## About

This package provides a simple HashMap implementation inspired by the Java HashMap API.
The following example show how to use the record class:

```php
<?php

use PSX\Record\Record;

$record = new Record();
$record->put('foo', 'bar');
$record->putAll(['bar' => 'foo']);

$record->containsKey('foo');

$record->get('foo');
$record->getOrDefault('foo', false);
$record->foo; // property access
$record['foo']; // array access

$record->remove('bar');

\json_encode($record); // results in {"foo": "bar"}

$record = Record::from(['foo' => 'bar']); // create a record from an array

```
