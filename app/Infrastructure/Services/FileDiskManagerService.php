<?php

namespace App\Infrastructure\Services;

use App\Core\Domain\Exception\NotFound\FileNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileDiskManagerService implements IFileDiskManagerService
{
    public function checkFile(string $addedPathFolder, string $filePath): bool
    {
        $filePath = $this->combineFilePath($addedPathFolder, $filePath);

        return Storage::exists($filePath);
    }

    public function combineFilePath(string $addedPathFolder, string $filePath): string
    {
        $filePath = 'uploads/' . $addedPathFolder . "/" . $filePath;

        return  $filePath;
    }

    public function uploadFile(UploadedFile $file, string $addedPathFolder): string|array
    {
        $randomFileName = uniqid() . '.' . $file->extension();

        try {
            $upload_result = $file->storeAs('uploads/' . $addedPathFolder, $randomFileName);

            if ($upload_result === false) {
                return ['1' => 'Upload file failed'];
            }
        }
        catch (\Exception $ex) {
            return ['1' => 'Upload file failed'];
        }

        return $randomFileName;
    }

    /**
     * @throws FileNotFoundException
     */
    public function deleteFile(string $addedPathFolder, string $filePath): bool
    {
        $fileExist = $this->checkFile($addedPathFolder, $filePath);
        if (!$fileExist) {
            throw new FileNotFoundException();
        }

        $filePath = $this->combineFilePath($addedPathFolder, $filePath);

        try {
            Storage::delete($filePath);
        }
        catch (\Exception $ex) {
            return false;
        }

        return true;
    }
}
