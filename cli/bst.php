<?php

use App\Bst\Generator;
use App\JsonDataProvider\JsonFileDataProvider;

require_once __DIR__ . '/../vendor/autoload.php';

$indexField = $argv[1];
$generator = new Generator(new JsonFileDataProvider('input.json'), $indexField);

file_put_contents('gen/bst.json', json_encode($generator->generate()->toArray()));
