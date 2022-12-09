<?php


interface AggregatorInterface {

    public function add(array $data);

    public function count($alias = 'count');

    public function every(int $nRecords, $callback);

    public function get($key = null, $default = null): array;

    public function groupBy( $key );

    public function percentile($percentile, $key, $alias = null);

    public function sample($limit, $key, $alias = null);

    public function sum($key, $alias = null);

    public function avg($key, $alias = null);

    public function first($key, $alias = null);

    public function last($key, $alias = null);

    public function min($key, $alias = null);

    public function max($key, $alias = null);

    public function distinct($key, $alias = null);

    public function countIf($callback, $alias = null);
}