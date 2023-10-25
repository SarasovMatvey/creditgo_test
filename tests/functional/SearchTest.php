<?php

namespace integration;

use App\Searcher\Searcher;
use App\Searcher\SearchStrategies\BstSearch;
use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase
{
    public function testGenerateBst() {
        copy(__DIR__ . '/fixtures/bst.json', __DIR__ . '/../../gen/bst.json');
        $output = shell_exec('php ' . __DIR__ . '/../../cli/search.php --searchField="name" --searchValue="Adhi Kot" --useBst="true"');

        $this->assertEquals(file_get_contents(__DIR__ . '/fixtures/output.txt'), $output);
    }
}