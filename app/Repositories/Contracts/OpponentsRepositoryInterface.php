<?php
namespace App\Repositories\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface OpponentsRepositoryInterface {

    /**
     * Uploads and inserts filename to database
     *
     * @param int $id Opponent ID
     * @param UploadedFile $file File request
     * @return bool
     */
    public function insertFile($id, UploadedFile $file);

    /**
     * Deletes the file from disk and database
     * 
     * @param  int $id Opponent ID
     * @return bool     Is the file deleted
     */
    public function deleteFile($id);

} 