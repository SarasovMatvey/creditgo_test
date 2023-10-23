<?php

namespace App\Bst;

interface Row {
    function getId(): int;
    function getFieldValue(string $field): mixed;
    function hasField(string $field): bool;
}