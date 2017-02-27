<?php
declare(strict_types = 1);

namespace Strayobject\Cravc\Calculator;

class AverageCalculator
{
    public function getAverage(array $values)
    {
        $count = count($values);

        return $count ? (array_sum($values) / $count) : 0;
    }
}
