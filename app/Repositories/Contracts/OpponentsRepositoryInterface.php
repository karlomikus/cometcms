<?php
namespace App\Repositories\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface OpponentsRepositoryInterface {

    /**
     * Uploads and inserts filename to database
     *
     * @param $id Opponent id
     * @param UploadedFile $file File request
     * @return bool
     */
    public function insertFile($id, UploadedFile $file);

} 