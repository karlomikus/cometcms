<?php
namespace App\Repositories\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface GamesRepositoryInterface {

    public function insertImage($gameID, UploadedFile $file);

    public function updateImage($gameID, UploadedFile $file);

    public function deleteImage($gameID);

} 