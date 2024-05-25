<?php 
/**
 *
 * @category zStarter
 *
 * @ref zCURD
 * @author  Defenzelite <hq@defenzelite.com>
 * @license https://www.defenzelite.com Defenzelite Private Limited
 * @version <zStarter: 1.1.0>
 * @link    https://www.defenzelite.com
 */

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait CanManageFiles
{
    public $file;
    public $dir;
    public $saveFileName;
    public $uploadedFileName;
    public $uploadedFilePath;
    public $uploadedFileNames;
    public $uploadedFilePaths;
    public $destination;

    /**
     * Uploads the file in storage
     * and also create a record in media table
     *
     * @param UploadedFile $file
     * @param string|null $dir
     * @param string|null $fileNamePrefix
     * @return $this
     */
    public function uploadFile($file, $dir = null, $fileNamePrefix = null)
    {
        $this->file = $file;
        $this->dir = $dir;

        $fileName = Str::random(64);
        $fileExtension = $this->file->getClientOriginalExtension();
        $uploadsHome = "uploads/";

        $this->saveFileName = $fileNamePrefix . $fileName . "." . strtolower($fileExtension);
        $this->dir = $this->dir ? $uploadsHome . $this->dir . "/" : $uploadsHome . "/";
        $this->destination = storage_path() . '/app/public/' . $this->dir;
		
		
        $this->uploadedFileName = $this->saveFileName;
        $this->uploadedFilePath = '/core/storage/app/public/' . $this->dir . $this->saveFileName;

        $this->file->move($this->destination, $this->saveFileName);

        return $this;
    }


    /**
     * Uploads the file in storage
     * and also create a record in media table
     *
     * @param array $files
     * @param string|null $dir
     * @param string|null $fileNamePrefix
     * @return $this
     */
    public function uploadFiles($files, $dir = null, $fileNamePrefix = null)
    {
        $this->dir = $dir;

        foreach ($files as $file) {
            $fileName = Str::random(64);
            $fileExtension = $file->getClientOriginalExtension();
            $uploadsHome = "uploads/";

            $this->saveFileName = $fileNamePrefix . $fileName . "." . strtolower($fileExtension);
            $this->dir = $this->dir ? $uploadsHome . $this->dir . "/" : $uploadsHome . "/";
            $this->destination = storage_path() . '/app/public/' . $this->dir;
            $this->uploadedFileNames[] = $this->saveFileName;
            $this->uploadedFilePaths[] = 'storage/' . $this->dir . $this->saveFileName;

            $file->move($this->destination, $this->saveFileName);
        }

        return $this;
    }


    /**
     * Returns the uploaded
     * media file name
     *
     * @return string|null
     */
    public function getFileName(): ?string
    {
        return $this->uploadedFileName;
    }

    /**
     * Returns the uploaded
     * media file path
     *
     * @return string|null
     */
    public function getFilePath(): ?string
    {
        return $this->uploadedFilePath;
    }


    /**
     * Returns the uploaded
     * media files name
     *
     * @return array|null
     */
    public function getFileNames(): ?array
    {
        return $this->uploadedFileNames;
    }

    /**
     * Returns the uploaded
     * media file names
     *
     * @return string|null
     */
    public function getFilePaths(): ?string
    {
        return $this->uploadedFilePaths;
    }



    /**
     * Delete any file from the given path
     *
     * @param mixed $path
     * @return $this
     */
    public function deleteFile($path)
    {
        if (File::exists($path)) {
            File::delete($path);
        }
        return $this;
    }


    /**
     * Delete file from the storage path
     *
     * @param mixed $path
     * @return $this
     */
    public function deleteStorageFile($path)
    {
        if (!is_null($path)) {
            if (explode('/', $path)[0] == 'storage') {
                $this->deleteFile(storage_path() . '/app/public/' . Str::replace('storage/', '', $path));
            } else {
                $this->deleteFile(storage_path() . '/app/public/' . $path);
            }
        }
        return $this;
    }


    /**
     * Delete file from the storage path
     *
     * @param array $files
     * @return $this
     */
    public function deleteStorageFiles($files)
    {
        if (!is_null($files)) {
            foreach ($files as $file) {
                $this->deleteStorageFile($file);
            }
        }
        return $this;
    }


    /**
     * Delete any directory from the given path
     *
     * @param mixed $path
     * @return $this
     */
    public function deleteDir($path)
    {
        if (File::isDirectory($path)) {
            File::deleteDirectory($path);
        }
        return $this;
    }


}