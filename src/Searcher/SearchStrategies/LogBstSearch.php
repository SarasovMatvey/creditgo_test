<?php

namespace App\Searcher\SearchStrategies;

class LogBstSearch extends BstSearch
{
    public function __construct(
        protected array $bst,
        protected int &$iterationsCounter
    )
    {
        parent::__construct($bst);
    }

    public function onIterationStart()
    {
        parent::onIterationStart();

        $this->iterationsCounter++;
    }
}