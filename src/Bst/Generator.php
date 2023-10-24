<?php

namespace App\Bst;

class Generator {
    /**
     * @var Row[]
     */
    protected array $indexingRows;

    /**
     * @var Node[]
     */
    protected array $unbindingNodes;

    public function __construct(
        protected DataProvider $dataProvider,
        protected string $fieldToIndex,
    )
    {
    }

    public function generate(): ?Node {
        $this->collectIndexingRows();
        $this->prepareUnbindingNodes();

        return $this->generateBstRecursive(0, count($this->unbindingNodes) - 1);
    }

    protected function collectIndexingRows() {
        $indexingRows = [];

        foreach ($this->dataProvider->provideData() as $row) {
            if (! in_array(
                gettype($row->getFieldValue($this->fieldToIndex)),
                ['integer', 'string', 'double']
            )) {
                continue;
            }

            if ($row->hasField($this->fieldToIndex)) {
                $indexingRows []= $row;
            }
        }

        $this->indexingRows = $indexingRows;
    }

    /**
     * @return Row[]
     */
    protected function findDuplicatedFieldValues(): array {
        $rowsValues = $this->rowsToValues();
        $duplicatedValues = [];

        foreach(array_count_values($rowsValues) as $value => $count) {
            if (is_null($value)) continue;

            if($count > 1) {
                $duplicatedValues[] = $value;
            };
        }

        return $duplicatedValues;
    }

    protected function rowsToValues(): array {
        return array_map(function($row) {
            return $row->getFieldValue($this->fieldToIndex);
        }, $this->indexingRows);
    }

    /**
     * @return Node[]
     */
    protected function rowsToNodes(): array {
        return array_map(function ($row) {
            return new Node(
                value: $row->getFieldValue($this->fieldToIndex),
                indexes: [$row->getId()],
                left: null,
                right: null,
            );
        }, $this->indexingRows);
    }

    protected function prepareUnbindingNodes() {
        $this->unbindingNodes = $this->rowsToNodes();

        $this->mergeDuplicatedNodes();
        $this->sortUnbindingNodes();
    }

    protected function mergeDuplicatedNodes() {
        $duplicatesHistory = [];

        foreach ($this->unbindingNodes as $i => $node) {
            if (in_array($node->getValue(), $this->findDuplicatedFieldValues())) {
                if (!array_key_exists($node->getValue(), $duplicatesHistory)) {
                    $duplicatesHistory[$node->getValue()] = [];
                }

                $duplicatesHistory[$node->getValue()] =
                    array_merge($duplicatesHistory[$node->getValue()], $node->getIndexes());

                unset($this->unbindingNodes[$i]);
            }
        }

        foreach ($duplicatesHistory as $value => $indexes) {
            $this->unbindingNodes []= new Node(
                value: $value,
                indexes: $indexes,
                left: null,
                right: null,
            );
        }
    }

    protected function sortUnbindingNodes() {
        usort($this->unbindingNodes, function($a, $b) {
            /** @var Node $a */
            /** @var Node $b */

            return $a->getValue() <=> $b->getValue();
        });
    }

    protected function generateBstRecursive($start, $end): ?Node {
        if ($end < $start) {
            return null;
        }
        $mid = floor(($start + $end) / 2);

        $node = $this->unbindingNodes[$mid];

        $node->setLeft($this->generateBstRecursive($start, $mid - 1));
        $node->setRight($this->generateBstRecursive($mid + 1, $end));

        return $node;
    }
}