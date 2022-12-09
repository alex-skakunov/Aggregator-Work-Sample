<?php

// require_once 'Aggregator.php';
require_once 'bootstrap.php';

$agg = new Aggregator;
$agg
  ->sum('points', 'sum_points')
  ->avg('points', 'avg_points')
  ->sum('score', 'sum_score')
  ->avg('score', 'avg_score')
  ->first('score')
  ->min('score')
  ->max('score')
  ->first('lesson_id')
  ->last('lesson_id')
  ->distinct('lesson_id', 'lessions list')
  ->countIf(function($row){
    return $row['score'] >= .1;
  }, 'good_score')
  ->countIf(function($row){
    return $row['points'] > 500;
  }, 'high_points')
  ->count('cnt')
  ->groupBy('con_id')
  ->percentile(75, 'points')
;


// $agg->every(1, function() use($agg){
// 	$data = $agg->get('good_score');
//     print_r($data);
// 	//$sendToSocket($data);
// });

$agg->add([
	'con_id' => 1,
	'points' => 100,
	'score' => .8,
	'lesson_id' => 'a'
]);


$agg->add([
    'con_id' => 2,
    'points' => 501,
    'score' => .1,
    'lesson_id' => 'b'         
]);


$agg->add([
    'con_id' => 1,
    'points' => 500,
    'score' => .5,
    'lesson_id' => 'x'         
]);

$agg->add([
    'con_id' => 4,
    'points' => 500,
    'score' => .5,
    'lesson_id' => 'x'
]);

$agg->add([
    'con_id' => 1,
    'points' => 600,
    'score' => .5,
    'lesson_id' => 'w'
]);

$agg->add([
    'con_id' => 1,
    'points' => 200,
    'score' => .5,
    'lesson_id' => 'w'
]);

$data = $agg->get();
print_r($data);

// $data = $agg->get('good_score');
// print_r($data);
