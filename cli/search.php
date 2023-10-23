<?php

use App\Helpers\ObjectHierarchySelector;
use App\Searcher\Searcher;
use App\Searcher\SearchStrategies\BstSearch;
use App\Searcher\SearchStrategies\SimpleSearch;

require_once __DIR__ . '/../vendor/autoload.php';

$cliArguments = getopt("", [
    'searchField:',
    'searchValue:',
    'useBst:'
]);

$searchField = $cliArguments['searchField'];
$searchValue = $cliArguments['searchValue'];
$useBst = !($cliArguments['useBst'] === 'false');

$documents = json_decode(file_get_contents('input.json'), true);
$bst = json_decode(file_get_contents('gen/bst.json'), true);

if ($searchField === $bst['field'] && $useBst) {
    var_dump(222222222222);
    $searcher = new Searcher(new BstSearch($bst['bst']));
    var_dump($searcher->search($searchValue));
} else {
    var_dump(111111111111);
    $searcher = new Searcher(new SimpleSearch($searchField, $documents, new ObjectHierarchySelector()));
    var_dump($searcher->search($searchValue));
}

