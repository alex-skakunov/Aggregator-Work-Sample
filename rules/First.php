<?php

namespace Rules;

class First extends RuleAbstract {

    protected function processNewValue(mixed $newValue): void {
        if (isset($this->value)) {  // set it only ones
            return;
        }

        $this->value = $newValue;
    }
}