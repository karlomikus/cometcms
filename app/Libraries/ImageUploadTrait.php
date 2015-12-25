<?php
namespace Comet\Libraries;

use Symfony\Component\HttpFoundation\File\UploadedFile;

trait ImageUploadTrait {

    private $_path;

    /**
     * Uploads and inserts image to database
     *
     * @param int           $id     Model entity ID
     * @param UploadedFile  $file   File object
     * @return bool
     */
    public function insertImage($id, UploadedFile $file)
    {
        // Set image name: [$id].jpg 
        $imageName = $id . '.' . $file->getClientOriginalExtension();

        try {
            $file->move($this->_path, $imageName);

            // Call default repository method to update image name
            parent::update($id, ['image' => $imageName]);

            return true;
        }
        catch (\Exception $e) {
            \Session::flash('exception', $e->getMessage());

            return false;
        }
    }

    /**
     * Updates model image property
     * 
     * @param  int          $id   Model entity ID
     * @param  UploadedFile $file File object
     * @return bool
     */
    public function updateImage($id, UploadedFile $file)
    {
        $this->deleteImage($id);
        $this->insertImage($id, $file);
    }

    /**
     * Deletes the file from disk and database
     * 
     * @param  int  $id  Model entity ID
     * @return bool
     */
    public function deleteImage($id)
    {
        $model = parent::get($id);
        $filename = $this->_path . $model->image;
        
        if (file_exists($filename) && is_file($filename)) {
            parent::update($id, ['image' => null]);

            // Don't delete images during development process
            if (\App::environment('local'))
                return true;

            return unlink($filename);
        }

        return false;
    }

    /**
     * Set upload path
     * 
     * @param string $path Full upload path
     */
    public function setUploadPath($path)
    {
        $this->_path = $path;
    }

}