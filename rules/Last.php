<?php

namespace Rules;

class Last extends RuleAbstract {

    protected function processNewValue(mixed $newValue): void {
        $this->value = $newValue; // just overwrite all the time
    }
}