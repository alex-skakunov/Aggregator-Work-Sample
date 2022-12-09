<?php

namespace Rules;

class Max extends RuleAbstract {
    protected $value;

    protected function processNewValue(mixed $newValue): void {
        if (!isset($this->value) || $newValue > $this->value) {
            $this->value = $newValue;
        }
    }
}