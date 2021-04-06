<?php

namespace App\Services\Installation;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\Currency;
use App\Models\CompanyType;
use App\Models\Membership;
use App\Models\FigureType;
use App\Services\Installation\Events\ApplicationWasInstalled;
use Closure;
use Illuminate\Validation\ValidationException;

/**
 * Class InstallAppHandler.
 */
class InstallAppHandler
{
    /**
     * @var array|\Illuminate\Support\Collection
     */
    public $roles = [
        ['name' => 'Owner'],
        ['name' => 'Super User'],
        ['name' => 'Collaborator/Employee'],
        ['name' => 'Instructor'],
    ];

    /**
     * @var array|\Illuminate\Support\Collection
     */
    public $permissions = [
        'permissions' => [
            ['name' => 'permission_1'],
            ['name' => 'permission_2'],
            ['name' => 'permission_3'],
            ['name' => 'permission_4'],
        ],
    ];

    
    public $adminUser;

    /**
     * InstallAppHandler constructor.
     */
    public function __construct()
    {
        $this->roles = collect($this->roles);
        $this->permissions = collect($this->permissions);
    }

    /**
     * @param $installationData
     * @param \Closure $next
     * @return mixed
     */
    public function handle($installationData, Closure $next)
    {
        $this->createRoles()->createPermissions()
             ->createAdminUser((array) $installationData)->assignAdminRoleToAdminUser()
             ->assignPermissionsToRoles();
        event(new ApplicationWasInstalled($this->adminUser, $this->roles, $this->permissions));

        return $next($installationData);
    }

    /**
     * @return $this
     */
    public function createRoles()
    {
        $this->roles = $this->roles->map(function ($role) {
            return Role::create($role);
        });

        return $this;
    }

    /**
     * @return $this
     */
    public function createPermissions()
    {
        $this->permissions = $this->permissions->map(function ($group) {
            return collect($group)->map(function ($permission) {
                return Permission::create($permission);
            });
        });

        return $this;
    }

    /**
     * @param array $attributes
     * @return $this
     * @throws ValidationException
     */
    public function createAdminUser(array $attributes = [])
    {
        $validator = validator($attributes, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $this->adminUser = User::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => $attributes['password'],
        ]);

        return $this;
    }

    /**
     * @return $this
     */
    public function assignAdminRoleToAdminUser()
    {
        $this->adminUser->assignRole('Owner');

        return $this;
    }

    /**
     * @return $this
     */
    public function assignPermissionsToRoles()
    {
        $role_admin = Role::where('name', 'Owner')->firstOrFail();
        $this->permissions->flatten()->each(function ($permission) use ($role_admin) {
            $role_admin->givePermissionTo($permission);
        });
        return $this;
    }

}
