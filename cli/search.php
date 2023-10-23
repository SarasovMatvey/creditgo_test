<?php

use App\Searcher\Searcher;

require_once __DIR__ . '/../vendor/autoload.php';

$searchField = $argv[1];
$searchValue = $argv[2];

$documents = json_decode(file_get_contents('input.json'), true);
$bst = json_decode(file_get_contents('gen/bst.json'), true);

$searcher = new Searcher($bst);
if ($searchField === $bst['field']) {
    var_dump($searcher->search($searchValue));
}

