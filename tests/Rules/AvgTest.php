<?php 
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class AvgTest extends TestCase
{
    public function testRule(): void
    {
        $rule = new Rules\Avg('score');
        $result = $rule->apply(['score' => 15]);
        $result = $rule->apply(['score' => 25]);
        $this->assertEquals(20, $result);
    }
}