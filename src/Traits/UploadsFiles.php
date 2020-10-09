<?php

namespace IndieHD\Velkart\Traits;

use Illuminate\Http\UploadedFile;

trait UploadsFiles
{
    /**
     * @param UploadedFile $file
     * @param string       $folder
     * @param string       $disk
     *
     * @return false|string
     */
    public function storeFile(UploadedFile $file, $folder = 'products', $disk = 'public')
    {
        return $file->store($folder, ['disk' => $disk]);
    }
}
