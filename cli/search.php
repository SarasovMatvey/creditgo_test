<?php

use App\Helpers\ObjectHierarchySelector;
use App\Searcher\Searcher;
use App\Searcher\SearchStrategies\LogBstSearch;
use App\Searcher\SearchStrategies\LogSimpleSearch;

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

$iterationsCounter = 0;
if ($searchField === $bst['field'] && $useBst) {
    $searcher = new Searcher(new LogBstSearch($bst['bst'], $iterationsCounter));
    $indexes = $searcher->search($searchValue);
    $resultDocuments = array_reduce($indexes, function (array $resultDocuments, array $indexes) use ($documents) {
        foreach ($indexes as $index) {
            $resultDocuments []= $documents[$index];
        }
        return $resultDocuments;
    }, []);
    var_dump($resultDocuments, $iterationsCounter);
} else {
    $searcher = new Searcher(new LogSimpleSearch(
        $searchField,
        $documents,
        new ObjectHierarchySelector(),
        $iterationsCounter
    ));
    $indexes = $searcher->search($searchValue);
    $resultDocuments = array_reduce($indexes, function (array $resultDocuments, array $indexes) use ($documents) {
        foreach ($indexes as $index) {
            $resultDocuments []= $documents[$index];
        }
        return $resultDocuments;
    }, []);
    var_dump($resultDocuments, $iterationsCounter);
}

