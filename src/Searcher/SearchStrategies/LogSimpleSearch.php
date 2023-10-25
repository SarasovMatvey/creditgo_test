<?php

namespace App\Searcher\SearchStrategies;

use App\Helpers\ObjectHierarchySelector;

class LogSimpleSearch extends SimpleSearch
{
    public function __construct(
        protected string $searchField,
        protected array $documents,
        protected ObjectHierarchySelector $objectHierarchySelector,
        protected int &$iterationsCounter
    ) {
        parent::__construct($searchField, $documents, $objectHierarchySelector);
    }

    public function onIterationStart()
    {
        parent::onIterationStart();

        $this->iterationsCounter++;
    }
}
