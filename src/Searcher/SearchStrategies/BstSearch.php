<?php

namespace App\Searcher\SearchStrategies;

use App\Searcher\SearchStrategy;

class BstSearch implements SearchStrategy
{
    public function __construct(
        protected array $bst,
    )
    {
    }

    /**
     * @return int[]|null
     */
    public function search(string $searchValue): ?array
    {
        return $this->searchRecursive($searchValue, $this->bst);
    }

    /**
     * @return int[]|null
     */
    public function searchRecursive(
        mixed $searchValue,
        array $root
    ): ?array {
        $this->onIterationStart();

        if ($searchValue === $root['value']) {
            return $root['indexes'];
        } elseif ($searchValue > $root['value']) {
            if (is_null($root['right'])) {
                return null;
            }

            return $this->searchRecursive($searchValue, $root['right']);
        } elseif ($searchValue < $root['value']) {
            if (is_null($root['left'])) {
                return null;
            }

            return $this->searchRecursive($searchValue, $root['left']);
        }

        return null;
    }

    function onIterationStart()
    {
    }
}