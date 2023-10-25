<?php

namespace App\Bst;

interface Row
{
    public function getId(): int;
    public function getFieldValue(string $field): mixed;
    public function hasField(string $field): bool;
}
