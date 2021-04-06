<?php

namespace App\Models;

use App\Support\HasPermissionsUuid;
use App\Support\UuidScopeTrait;
use App\Models\User;

/**
 * Class Role.
 */
class Role extends \Spatie\Permission\Models\Role
{
    use UuidScopeTrait, HasPermissionsUuid;

    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'uuid', 'guard_name'];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
