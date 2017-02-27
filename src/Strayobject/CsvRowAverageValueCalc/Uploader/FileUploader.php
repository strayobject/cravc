<?php
declare(strict_types=1);

namespace Strayobject\Cravc\Uploader;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    /**
     * @var string
     */
    private $savePath;

    public function __construct(string $saveLocation)
    {
        $this->savePath = $saveLocation;
    }

    /**
     * @param UploadedFile $file
     * @param string $filename
     * @throws FileException
     * @return File
     */
    public function upload(UploadedFile $file, string $filename): File
    {
        return $file->move($this->savePath, $filename);
    }
}
