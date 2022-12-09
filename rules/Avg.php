<?php

namespace Rules;

/**
 * calculates the average value (sum divided by count)
 */
class Avg extends RuleAbstract {
    protected $count = 0;
    protected $sum = 0;

    protected function processNewValue(mixed $newValue): void {
        $this->sum += $newValue;
        $this->count++;
        $this->value = ($this->count !== 0)
            ? $this->sum / $this->count
            : 0;
    }
}