<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Transformers\Users\UserTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Mail;

use App\Models\Role;
use App\Models\Permission;

/**
 * Class UsersController.
 *
 * @author Jose Fonseca <jose@ditecnologia.com>
 */
class UsersController extends Controller
{
    use Helpers;

    /**
     * @var \App\Model\\App\Models\User
     */
    protected $model;

    /**
     * UsersController constructor.
     *
     * @param \App\Model\User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Returns the Users resource with the roles relation.
     *
     * @param Request $request
     * @return mixed
     */
    public function index()
    {
        $users =  $this->model->all();
        return response($users->toArray());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $user = $this->model->find($id);
        return response($user->toArray());
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role_id' => 'required',
        ]);

        $data = $request->all();        
        $user = $this->model->create($data);
        
        if ($request->has('role_id')) {
            $role_id = $request['role_id']; 
            $role = Role::find($role_id);
            $user->syncRoles($role->uuid);
        }

        return $this->response->noContent();
    }

    /**
     * @param Request $request
     * @param $uuid
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $user = $this->model->find($id);
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'name' => 'sometimes|required',
                'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            ];
        }
        $this->validate($request, $rules);
        // Except password as we don't want to let the users change a password from this endpoint
        $user->update($request->except('_token', 'password'));

        if ($request->has('role_id')) {
            $role_id = $request['role_id']; 
            $role = Role::find($role_id);
            $user->syncRoles($role->uuid);
        }

        return $this->response->item($user->fresh(), new UserTransformer());
    }

    /**
     * @param Request $request
     * @param $uuid
     * @return mixed
     */
    public function destroy($id)
    {
        $user = $this->model->find($id);
        $user->delete();
        return $this->response->noContent();
    }

}
