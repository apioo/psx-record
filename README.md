
# Record

## About

This package provides a simple HashMap implementation inspired by the Java HashMap API.
The following example shows how to use the record class:

```php
<?php

use PSX\Record\Record;

$record = new Record();
$record->put('foo', 'bar');
$record->putAll(['bar' => 'foo']);

$record->containsKey('foo'); // checks whether the key exists
$record->containsValue('bar'); // checks whether the value exists (strict type check)

$record->get('foo');
$record->getOrDefault('foo', false);
$record->foo; // property access
$record['foo']; // array access

$record->remove('bar');

$record->keySet(); // returns all keys as indexed array
$record->size(); // returns the size of the map
$record->values(); // returns all values as indexed array

\json_encode($record); // results in {"foo": "bar"}

$record = Record::from(['foo' => 'bar']); // create a record from an array

```
