<?php 
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class AggregatorTest extends TestCase
{
    protected function feedAggregator($agg) { 
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
            'con_id' => 1,
            'points' => 200,
            'score' => .5,
            'lesson_id' => 'w'
        ]);
    }

    public function testSum(): void
    {
        $agg = new Aggregator;
        $agg
            ->sum('points', 'sum_points')
            ->groupBy('con_id');

        $this->feedAggregator($agg);
        $result = $agg->get();
        $expected = [
            1 => [
                'con_id' => 1,
                'sum_points' => 800
            ],
            2 => [
                'con_id' => 2,
                'sum_points' => 501
            ]
        ];

        $this->assertEquals($expected, $result);
    }


    public function testAvg(): void
    {
        $agg = new Aggregator;
        $agg
            ->avg('points')
            ->groupBy('con_id');

        $this->feedAggregator($agg);
        $result = $agg->get();
        $expected = [
            1 => [
                'con_id' => 1,
                'avg_points' => 266.6666666666667
            ],
            2 => [
                'con_id' => 2,
                'avg_points' => 501
            ]
        ];

        $this->assertEquals($expected, $result);
    }
}