<?php
namespace Comet\Core\Models;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Comet\Role
 *
 * @property integer $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Config::get('auth.model[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\Config::get('entrust.permission[] $perms
 * @method static \Illuminate\Database\Query\Builder|\Comet\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Role whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Comet\Role whereUpdatedAt($value)
 * @property string $deleted_at
 */
class Role extends EntrustRole
{
    use SoftDeletes;

    protected $guarded = ['id'];
}
