<?php 
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class CountTest extends TestCase
{
    public function testRule(): void
    {
        $rule = new Rules\Count('score');
        $result = $rule->apply(['score' => 15]);
        $result = $rule->apply(['score' => 25]);
        $this->assertEquals(2, $result);
    }
}