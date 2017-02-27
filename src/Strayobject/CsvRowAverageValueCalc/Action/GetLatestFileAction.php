<?php
declare(strict_types=1);

namespace Strayobject\Cravc\Action;

use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;

class GetLatestFileAction
{
    /**
    * @var string
    */
    private $filePath;

    public function __construct(
        string $fileLocation,
        string $filename
    ) {
        $this->filePath = sprintf('%s/%s', $fileLocation, $filename);
    }

    public function __invoke(Request $request): string
    {
        if (!is_readable($this->filePath)) {
            throw new AccessDeniedException($this->filePath);
        }

        return file_get_contents($this->filePath);
    }
}
