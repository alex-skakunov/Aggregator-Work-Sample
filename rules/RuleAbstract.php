<?php

namespace Rules;

abstract class RuleAbstract implements RuleInterface {
    protected $value;

    protected string $fieldName;

    public function __construct($fieldName) {
        $this->fieldName = $fieldName;
    }

    public function apply(array $row) {
        if (!isset($row[$this->fieldName])) {
            return;
        }

        $newValue = $row[$this->fieldName];
        $this->processNewValue($newValue);
        return $this->value;
    }

    abstract protected function processNewValue(mixed $newValue): void;
}