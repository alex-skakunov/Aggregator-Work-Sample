<?php

namespace Rules;

class Count extends RuleAbstract {
    protected $value = 0;

    public function apply(array $row) {
        $this->processNewValue(null);
        return $this->value;
    }

    protected function processNewValue(mixed $newValue): void {
        $this->value++;
    }
}