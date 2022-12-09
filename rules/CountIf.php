<?php

namespace Rules;

class CountIf extends Count {
    protected $callback;

    public function __construct($callback) {
        $this->callback = $callback;
    }

    public function apply(array $row) {
        $callback = $this->callback;
        $isSatisfied = $callback($row);

        if (!$isSatisfied) {
            return;
        }
        $res = parent::apply($row);

        return $res;
    }

}