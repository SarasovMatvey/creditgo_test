<?php

namespace App\Bst;

class Node {
    public function __construct(
        protected mixed $value,
        protected int|array $index,
        protected ?Node $left,
        protected ?Node $right,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'index' => $this->index,
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

    public function getIndex(): int|array
    {
        return $this->index;
    }

    public function setIndex(int|array $index): void
    {
        $this->index = $index;
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