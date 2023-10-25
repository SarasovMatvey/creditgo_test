<?php

namespace App\Searcher;

interface SearchStrategy
{
    /**
     * @return ?int[]
     */
    public function search(string $searchValue): ?array;

    public function onIterationStart();
}
