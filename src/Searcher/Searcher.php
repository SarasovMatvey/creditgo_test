<?php

namespace App\Searcher;

class Searcher
{
    public function __construct(
        protected SearchStrategy $searchStrategy,
    ) {
    }

    /**
     * @return ?int[]
     */
    public function search(mixed $searchValue): ?array
    {
        return $this->searchStrategy->search($searchValue);
    }
}
