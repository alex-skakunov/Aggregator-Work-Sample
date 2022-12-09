<?php

namespace Rules;

interface RuleInterface {

    public function apply(array $row);

}