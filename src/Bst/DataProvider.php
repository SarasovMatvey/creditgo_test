<?php

namespace App\Bst;

interface DataProvider
{
    /**
     * @return Row[]
     */
    public function provideData(): array;
}
