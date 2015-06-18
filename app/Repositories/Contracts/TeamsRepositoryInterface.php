<?php
namespace App\Repositories\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface TeamsRepositoryInterface {

    /**
     * Get members of a specific team
     *
     * @param $teamID
     * @return mixed
     */
    public function getTeamData($teamID);

    /**
     * Add members to specific team
     *
     * @param  array $data Array with member data
     * @param  int $teamID ID of the team we are adding members to
     * @return void           Void since we use transaction in insert() method
     */
    public function insertMembers($data, $teamID);

    /**
     * Uploads the image and updates database reference
     *
     * @param  UploadedFile $file File
     * @param  int $teamID ID of the team
     * @return bool               Was file uploaded or not
     */
    public function updateImage(UploadedFile $file, $teamID);

    /**
     * Delete all members from specific team
     *
     * @param  int $teamID Team ID
     * @return bool
     */
    public function deleteAllMembers($teamID);

} 