<?php

namespace App\JsonDataProvider;

class Row implements \App\Bst\Row
{
    public function __construct(
        protected int $id,
        protected array $document
    )
    {
    }

    function getId(): int
    {
        return $this->id;
    }

    function getFieldValue(string $field): mixed
    {
        return $this->document[$field];
    }

    function hasField(string $field): bool
    {
        return array_key_exists($field, $this->document);
    }
}