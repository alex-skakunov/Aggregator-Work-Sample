<?php

namespace Rules;

/**
 * calculates the average value (sum divided by count)
 */
class Percentile implements RuleInterface {
    protected $value;

    protected string $fieldName;

    protected int $percentileValue;

    protected $sortedValuesList = [];

    public function __construct(string $fieldName, int $percentileValue) {
        $this->fieldName = $fieldName;
        $this->percentileValue = $percentileValue;
    }

    public function apply(array $row) {
        if (!isset($row[$this->fieldName])) {
            return;
        }

        $newValue = $row[$this->fieldName];
        $this->processNewValue($newValue);
        return $this->value;
    }

    protected function processNewValue(mixed $newValue): void {
        $this->sortedValuesList[] = $newValue;
        sort($this->sortedValuesList);
        $index = floor($this->percentileValue / 100 * count($this->sortedValuesList));
        if ($index > 0) {
            $index--; // the formula is 1-based, a PHP array is 0-based
        }
        $this->value = $this->sortedValuesList[$index];
    }
}