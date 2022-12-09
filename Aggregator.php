<?php

use Exceptions\NotImplementedException;
use Exceptions\NoGroupbyFieldSetException;

class Aggregator implements AggregatorInterface {

    protected string $groupbyFieldName;

    protected array $rulesDefinitionList = [];
    protected array $rulesRegistry = [];
    protected array $statistics = [];

    protected int $recordsProcessed = 0;
    protected int $recordsModuloToCallback = 0;
    protected $callbackOnReachingLimit;


    public function groupBy($key) {
        $this->groupbyFieldName = $key;
        return $this;
    }

    public function add(array $row) {
        if (!isset($this->groupbyFieldName)) {
            throw new NoGroupbyFieldSetException;
        }

        $groupbyValue = $row[$this->groupbyFieldName]; // 1 = $row['con_id']

        // initialize a new rules list for current group
        if (!isset($this->rulesRegistry[$groupbyValue])) {
            $this->rulesRegistry[$groupbyValue] = [];
            // specify the field name and value, like con_id = 1
            $this->statistics[$groupbyValue][$this->groupbyFieldName] = $groupbyValue;

            foreach ($this->rulesDefinitionList as $alias => $ruleDefinition) {
                $className = sprintf('Rules\\%s', \strtoupper($ruleDefinition['method']));
                $this->rulesRegistry[$groupbyValue][$alias] = new $className($ruleDefinition['key'], $ruleDefinition['extraValue']);
            }
        }

        // re-apply the rules for this group
        $rulesList = $this->rulesRegistry[$groupbyValue];
        foreach ($rulesList as $alias => $rule) {
            $this->statistics[$groupbyValue][$alias] = $rule->apply($row);
        }

        $this->recordsProcessed++;
        if (!empty($this->recordsModuloToCallback > 0)) {
            if ($this->recordsProcessed % $this->recordsModuloToCallback == 0) {
                $callback = $this->callbackOnReachingLimit;
                $callback();
            }

        }

        return $this;
    }

    public function get($key = null, $default = null): array {
        if (!empty($key)) {
            $output = [];
            foreach ($this->statistics as $groupbyValue => $data) {
                $value = $data[$key] ?? null;
                $output[$groupbyValue][$key] = $value;
            }
            return $output;
        }

        return $this->statistics;
    }

    public function every(int $nRecords, $callback) {
        $this->recordsModuloToCallback = $nRecords;
        $this->callbackOnReachingLimit = $callback;
        return $this;
    }

    public function count($alias = 'count') {
        return $this->addRuleDefinition(__FUNCTION__, 'count', $alias);
    }

    public function sum($key, $alias = null) {
        return $this->addRuleDefinition(__FUNCTION__, $key, $alias);
    }

    public function avg($key, $alias = null) {
        return $this->addRuleDefinition(__FUNCTION__, $key, $alias);
    }

    public function first($key, $alias = null) {
        return $this->addRuleDefinition(__FUNCTION__, $key, $alias);
    }

    public function last($key, $alias = null) {
        return $this->addRuleDefinition(__FUNCTION__, $key, $alias);
    }

    public function min($key, $alias = null) {
        return $this->addRuleDefinition(__FUNCTION__, $key, $alias);
    }

    public function max($key, $alias = null) {
        return $this->addRuleDefinition(__FUNCTION__, $key, $alias);
    }

    public function distinct($key, $alias = null) {
        return $this->addRuleDefinition(__FUNCTION__, $key, $alias);
    }

    public function countIf($callback, $alias = null) {
        return $this->addRuleDefinition(__FUNCTION__, $callback, $alias);
    }


    public function percentile($percentile, $key, $alias = null) {
        return $this->addRuleDefinition(__FUNCTION__, $key, $alias, $percentile);
    }


    public function sample( $limit, $key, $alias = null) {
        throw new NotImplementedException;
    }

    public function formula( Closure $callback, $alias ) {
        throw new NotImplementedException;
    }

    protected function addRuleDefinition($method, $key = null, $alias = null, $extraValue = null) {
        if (empty($alias)) {
            $alias = sprintf('%s_%s', \strtolower($method), (string)$key);
        }

        $this->rulesDefinitionList[$alias] = [
            'method' => $method,
            'key' => $key,
            'extraValue' => $extraValue
        ];

        return $this;
    }
}