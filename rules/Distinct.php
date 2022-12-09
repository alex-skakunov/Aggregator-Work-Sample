<?php

namespace Rules;

class Distinct extends RuleAbstract {
    protected $value = []; //unique list

    protected function processNewValue(mixed $newValue): void {
        if (in_array($newValue, $this->value)) {
            return;
        }

        $this->value[] = $newValue;
    }
}