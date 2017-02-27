<?php
declare(strict_types = 1);

namespace Strayobject\Cravc\Writer;

use InvalidArgumentException;
use League\Csv\Writer;

class CsvDataWriter
{
    /**
     * @var Writer
     */
    private $writer;

    public function __construct(
        string $writePath
    ) {
        $this->writer = Writer::createFromPath($writePath, 'w+');
    }

    /**
     * @param array $data
     * @throws InvalidArgumentException
     * @return Writer
     */
    public function writeData(array $data): Writer
    {
        return $this->writer->insertAll($data);
    }
}
