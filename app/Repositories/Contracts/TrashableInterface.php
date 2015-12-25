<?php
namespace Comet\Repositories\Contracts;

interface TrashableInterface {

    /**
     * Get all trashed items
     * 
     * @return mixed
     */
    public function getTrash();

    /**
     * Restore one item from trash
     * 
     * @param  int $id ID of item to restore
     * @return bool
     */
    public function restoreFromTrash($id);

    /**
     * Permanently delete one item. This affects all his references.
     * 
     * @param  int $id ID of item to delete
     * @return bool
     */
    public function deleteFromTrash($id);

    /**
     * Restore all items from trash
     * 
     * @return bool
     */
    public function restoreAll();

    /**
     * Permanently delete all items from trash
     * 
     * @return bool
     */
    public function emptyAll();

}