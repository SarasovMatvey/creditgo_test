<?php

use App\Bst\DataProviders\JsonFileDataProvider;
use App\Bst\Generator;

require_once __DIR__ . '/../vendor/autoload.php';

$cliArguments = getopt("", [
    'indexField:',
]);

$indexField = $cliArguments['indexField'];
$generator = new Generator(new JsonFileDataProvider('input.json'), $indexField);

file_put_contents('gen/bst.json', json_encode([
    'field' => $indexField,
    'bst' => $generator->generate()?->toArray(),
]));
