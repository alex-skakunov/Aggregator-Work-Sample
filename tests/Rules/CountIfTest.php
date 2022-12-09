<?php 
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class CountIfTest extends TestCase
{
    public function testRule(): void
    {
        $rule = new Rules\CountIf(function($row) {return $row['score'] > 0.5;}, 'count');
        $result = $rule->apply(['score' => 0.6]);
        $result = $rule->apply(['score' => 0.1]);
        $result = $rule->apply(['score' => 0.0]);
        $result = $rule->apply(['score' => 0.9]);

        $this->assertEquals(2, $result);
    }
}