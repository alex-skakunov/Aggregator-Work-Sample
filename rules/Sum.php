<?php

namespace Rules;

class Sum extends RuleAbstract {

    protected function processNewValue(mixed $newValue): void {
        $this->value += $newValue;
    }
}