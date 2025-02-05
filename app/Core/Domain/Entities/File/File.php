<?php

namespace App\Core\Domain\Entities\File;

use App\Core\Domain\Enums\FileTypes;

class File
{
    private int $fileId;
    private FileTypes $fileType;
    private string $fileName;

    public function __construct($fileId, FileTypes $fileType, string $fileName)
    {
        $this->fileId = $fileId;
        $this->fileType = $fileType;
        $this->fileName = $fileName;
    }

    public function getFileId(): int
    {
        return $this->fileId;
    }

    public function setFileId(int $fileId): void
    {
        $this->fileId = $fileId;
    }

    public function getFileType(): FileTypes
    {
        return $this->fileType;
    }

    public function setFileType(FileTypes $fileType): void
    {
        $this->fileType = $fileType;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }
}
