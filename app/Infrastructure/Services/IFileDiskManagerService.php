<?php

namespace App\Infrastructure\Services;


use Illuminate\Http\UploadedFile;

interface IFileDiskManagerService
{
    public function checkFile(string $addedPathFolder, string $filePath);
    public function combineFilePath(string $addedPathFolder, string $filePath);
    public function uploadFile(UploadedFile $file, string $addedPathFolder): string|array;
    public function deleteFile(string $addedPathFolder, string $filePath): bool;
}
