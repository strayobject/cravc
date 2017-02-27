<?php

namespace Strayobject\Cravc\Tests\Calculator;

use PHPUnit\Framework\TestCase;
use Strayobject\Cravc\Calculator\AverageCalculator;

class AverageCalculatorTest extends TestCase
{
    protected $calc;

    public function setUp()
    {
        $this->calc = new AverageCalculator();
    }

    public function testAverageReturned()
    {
        $this->assertSame(2, $this->calc->getAverage([2,2]));
    }
}
