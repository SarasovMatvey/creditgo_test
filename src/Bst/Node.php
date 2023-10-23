<?php

namespace App\Bst;

class Node {
    public function __construct(
        protected mixed $value,
        protected array $indexes,
        protected ?Node $left,
        protected ?Node $right,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'indexes' => $this->indexes,
            'left' => $this->left?->toArray(),
            'right' => $this->right?->toArray(),
        ];
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    /**
     * @return int[]
     */
    public function getIndexes(): array
    {
        return $this->indexes;
    }

    /**
     * @param int[] $indexes
     */
    public function setIndexes(array $indexes): void
    {
        $this->indexes = $indexes;
    }

    public function getLeft(): ?Node
    {
        return $this->left;
    }

    public function setLeft(?Node $left): void
    {
        $this->left = $left;
    }

    public function getRight(): ?Node
    {
        return $this->right;
    }

    public function setRight(?Node $right): void
    {
        $this->right = $right;
    }
}