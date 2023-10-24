<?php

use App\Cli\Formatter;
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

$bstFilePath = 'gen/bst.json';
$bst = null;
if (file_exists($bstFilePath)) {
    $bstFileContent = file_get_contents($bstFilePath);
    if ($bstFileContent) {
        $bst = json_decode($bstFileContent, true);
    }
}

$iterationsCounter = 0;
$resultDocuments = [];
$searcher = null;

if ($bst && $searchField === $bst['field'] && $useBst) {
    $searcher = new Searcher(new LogBstSearch($bst['bst'], $iterationsCounter));
} else {
    $searcher = new Searcher(new LogSimpleSearch(
        $searchField,
        $documents,
        new ObjectHierarchySelector(),
        $iterationsCounter
    ));
}

$indexes = $searcher->search($searchValue);
foreach ($indexes as $index) {
    $resultDocuments []= $documents[$index];
}

$formatter = new Formatter();
$formattedOutput = $formatter->format($iterationsCounter, $resultDocuments);
echo $formattedOutput;

