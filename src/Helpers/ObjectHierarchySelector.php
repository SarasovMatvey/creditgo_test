<?php

namespace App\Helpers;

class ObjectHierarchySelector
{
    public function select(array $data, string $query): mixed {
        if (!static::has($data, $query)) {
            return null;
        }

        if (str_contains($query, '.')) {
            $hierarchy = explode('.', $query);

            $currentCursor = null;
            foreach ($hierarchy as $hierarchyItem) {
                if (is_null($currentCursor)) {
                    $currentCursor = $data[$hierarchyItem];
                } else {
                    $currentCursor = $currentCursor[$hierarchyItem];
                }
            }

            return $currentCursor;
        }

        return $data[$query];
    }

    public function has(array $data, string $query): bool {
        if (str_contains($query, '.')) {
            $hierarchy = explode('.', $query);

            $currentCursor = null;
            foreach ($hierarchy as $hierarchyItem) {
                if (is_null($currentCursor)) {
                    if (array_key_exists($hierarchyItem, $data)) {
                        $currentCursor = $data[$hierarchyItem];
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

        return array_key_exists($query, $data);
    }
}