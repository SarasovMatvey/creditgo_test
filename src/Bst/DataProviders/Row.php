<?php

namespace App\Bst\DataProviders;

use App\Helpers\ObjectHierarchySelector;

class Row implements \App\Bst\Row
{
    public function __construct(
        protected int $id,
        protected array $document,
        protected ObjectHierarchySelector $objectHierarchySelector,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFieldValue(string $field): mixed
    {
        return $this->objectHierarchySelector->select($this->document, $field);
    }

    public function hasField(string $field): bool
    {
        return $this->objectHierarchySelector->has($this->document, $field);
    }
}
