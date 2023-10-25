<?php

namespace integration;

use App\Searcher\Searcher;
use App\Searcher\SearchStrategies\BstSearch;
use PHPUnit\Framework\TestCase;

class SearchWithBstTest extends TestCase
{
    public function testGenerateBst() {
        $bst = json_decode(file_get_contents(__DIR__ . '/fixtures/bst.json'), true);
        $searcher = new Searcher(new BstSearch($bst['bst']));
        $indexes = $searcher->search('Abee');

        $this->assertEquals([2], $indexes);
    }
}