<?php

namespace App\JsonDataProvider;

use App\Bst\DataProvider;
use App\Bst\Row;

class JsonFileDataProvider implements DataProvider
{
    public function __construct(
        protected string $inputFilePath
    )
    {
    }

    /**
     * @return Row[]
     */
    function provideData(): array
    {
        $documents = json_decode(file_get_contents($this->inputFilePath), true);

        $data = [];
        foreach ($documents as $i => $document) {
            $data []= new \App\JsonDataProvider\Row($i, $document);
        }

        return $data;
    }
}