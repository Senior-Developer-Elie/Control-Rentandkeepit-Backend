<?php

namespace App\Models;

use App\Support\UuidScopeTrait;

/**
 * Class Permission.
 */
class Permission extends \Spatie\Permission\Models\Permission
{
    use UuidScopeTrait;

    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'type', 'uuid', 'guard_name'];
}
