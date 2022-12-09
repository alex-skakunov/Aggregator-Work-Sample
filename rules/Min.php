<?php

namespace Rules;

class Min extends RuleAbstract {

    protected function processNewValue(mixed $newValue): void {
        if (!isset($this->value) || $newValue < $this->value) {
            $this->value = $newValue;
        }
    }
}