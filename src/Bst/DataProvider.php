<?php

namespace App\Bst;

interface DataProvider {
    /**
     * @return Row[]
     */
    function provideData(): array;
}