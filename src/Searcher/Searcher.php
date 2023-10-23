<?php

namespace App\Searcher;

class Searcher
{
    public function __construct(
        protected array $bst,
    )
    {
    }

    public function search(mixed $searchValue) {
        return $this->searchRecursive($searchValue, $this->bst['bst']);
    }

    /**
     * @return int[]|null
     */
    public function searchRecursive(
        mixed $searchValue,
        array $root
    ): ?array {
        if ($searchValue === $root['value']) {
            return $root['index'];
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
}