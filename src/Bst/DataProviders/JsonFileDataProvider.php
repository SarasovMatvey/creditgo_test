<?php

namespace App\Bst\DataProviders;

use App\Bst\DataProvider;
use App\Bst\Row;
use App\Helpers\ObjectHierarchySelector;

class JsonFileDataProvider implements DataProvider
{
    public function __construct(
        protected string $inputFilePath
    ) {
    }

    /**
     * @return \App\Bst\DataProviders\Row[]
     */
    public function provideData(): array
    {
        $documents = json_decode(file_get_contents($this->inputFilePath), true);

        $data = [];
        foreach ($documents as $i => $document) {
            $data [] = new \App\Bst\DataProviders\Row($i, $document, new ObjectHierarchySelector());
        }

        return $data;
    }
}
