<?php 
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class DistinctTest extends TestCase
{
    public function testRule(): void
    {
        $rule = new Rules\Distinct('score');
        $result = $rule->apply(['score' => 15]);
        $result = $rule->apply(['score' => 25]);
        $result = $rule->apply(['score' => 25]);
        $this->assertEquals([15, 25], $result);
    }
}