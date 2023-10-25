<?php

namespace App\Searcher\SearchStrategies;

use App\Helpers\ObjectHierarchySelector;
use App\Searcher\SearchStrategy;

class SimpleSearch implements SearchStrategy
{
    public function __construct(
        protected string $searchField,
        protected array $documents,
        protected ObjectHierarchySelector $objectHierarchySelector,
    ) {
    }

    /**
     * @return int[]|null
     */
    public function search(string $searchValue): ?array
    {
        $indexes = [];

        foreach ($this->documents as $i => $document) {
            $this->onIterationStart();

            $searchFieldValue = $this->objectHierarchySelector->select($document, $this->searchField);

            if ($searchFieldValue === $searchValue) {
                $indexes [] = $i;
            }
        }

        return $indexes;
    }

    public function onIterationStart()
    {
    }
}
