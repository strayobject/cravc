<?php
declare(strict_types=1);

namespace Strayobject\Cravc\Uploader;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

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

    public function upload(UploadedFile $file, string $filename): File
    {
        return $file->move($this->savePath, $filename);
    }
}
