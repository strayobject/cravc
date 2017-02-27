<?php
declare(strict_types = 1);

namespace Strayobject\Cravc\Provider;

use League\Csv\Reader;
use Strayobject\Cravc\Calculator\AverageCalculator;

class CalculatedDataProvider
{
    /**
     * @var AverageCalculator
     */
    private $calculator;

    /**
     * @var Reader
     */
    private $reader;

    public function __construct(
        string $readPath,
        AverageCalculator $calculator
    ) {
        $this->calculator = $calculator;
        $this->reader = Reader::createFromPath($readPath);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->reader->fetchAll(function ($row) {
            $avg = $this->calculator->getAverage($row);
            $row[] = $avg;

            return $row;
        });
    }
}
