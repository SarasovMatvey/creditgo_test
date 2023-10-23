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
        if (str_contains($field, '.')) {
            if (!$this->hasField($field)) {
                return null;
            }

            $hierarchy = explode('.', $field);

            $currentCursor = null;
            foreach ($hierarchy as $hierarchyItem) {
                if (is_null($currentCursor)) {
                    $currentCursor = $this->document[$hierarchyItem];
                } else {
                    $currentCursor = $currentCursor[$hierarchyItem];
                }
            }

            return $currentCursor;
        }

        return $this->document[$field];
    }

    function hasField(string $field): bool
    {
        if (str_contains($field, '.')) {
            $hierarchy = explode('.', $field);

            $currentCursor = null;
            foreach ($hierarchy as $hierarchyItem) {
                if (is_null($currentCursor)) {
                    if (array_key_exists($hierarchyItem, $this->document)) {
                        $currentCursor = $this->document[$hierarchyItem];
                    } else {
                        return false;
                    }
                } else {
                    if (array_key_exists($hierarchyItem, $currentCursor)) {
                        $currentCursor = $currentCursor[$hierarchyItem];
                    } else {
                        return false;
                    }
                }
            }

            return true;
        }

        return array_key_exists($field, $this->document);
    }
}