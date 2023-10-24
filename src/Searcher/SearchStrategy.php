<?php

namespace App\Searcher;

interface SearchStrategy
{
    /**
     * @return ?int[]
     */
    function search(string $searchValue): ?array;

    function onIterationStart();
}