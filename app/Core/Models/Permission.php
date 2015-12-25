<?php
namespace Comet\Core\Models;

use Zizaco\Entrust\EntrustPermission;

/**
 * Comet\Permission
 *
 * @property integer $id 
 * @property string $name 
 * @property string $display_name 
 * @property string $description 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Illuminate\Database\Eloquent\Collection|\Config::get('entrust.role[] $roles 
 * @method static \Illuminate\Database\Query\Builder|\Comet\Permission whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Permission whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Permission whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Permission whereUpdatedAt($value)
 */
class Permission extends EntrustPermission {

}