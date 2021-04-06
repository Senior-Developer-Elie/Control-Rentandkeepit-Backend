<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use App\Transformers\Users\PermissionTransformer;
use App\Transformers\Users\UserTransformer;

use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

/**
 * Class PermissionsController.
 */
class PermissionsController extends Controller
{
    use Helpers;

    /**
     * @var
     */
    protected $model;

    /**
     * PermissionsController constructor.
     *
     * @param \App\Models\Permission $model
     */
    public function __construct(Permission $model)
    {
        $this->model = $model;
        //$this->middleware('permission:list_permissions');
    }

    /**
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function index(Request $request)
    {
        //$paginator = $this->model->paginate($request->get('limit', config('app.pagination_limit')));
        //if ($request->has('limit')) {
        //    $paginator->appends('limit', $request->get('limit'));
        //}

        $permissions = $this->model->all();
        return $this->response->item($permissions, new PermissionTransformer());
    }

    public function getAllPermissions()
    {
        $permissions = $this->model->where('type', 'give')->get();
        return $this->response->item($permissions, new PermissionTransformer());
    }
    
    public function getPermissionsForUserViaRole($id)
    {
        $user = User::find($id);
        return response($user->getPermissionsViaRoles()->toArray());
    }
    public function getPermissionsForUser($id)
    {
        $user = User::find($id);
        //return response($user->getPermissionsViaRoles()->toArray());
        return response($user->getAllPermissions()->toArray());
    }

    //$id is user id
    public function givePermissionsToUser(Request $request, $id)
    {
        $user = User::find($id);
        
        if($request['addPermissionIds'] != '') {
            $addPermissionIds = explode(',', $request['addPermissionIds']);
            //return response((int)$addPermissionIds[0]);
            foreach($addPermissionIds as $addPermissionId) {                
                if((int)$addPermissionId != 0 && $user->hasPermissionTo((int)$addPermissionId) != 1) {
                    $permission = $this->model->find((int)$addPermissionId);
                    $user->givePermissionTo($permission->name);
                }
            }    
        }

        if($request['deletePermissionIds'] != '') {
            //return response('true');
            $deletePermissionIds = explode(',', $request['deletePermissionIds']);
            foreach($deletePermissionIds as $deletePermissionId) {
                if((int)$deletePermissionId != 0 && $user->hasPermissionTo((int)$deletePermissionId) == 1) {
                    $permission = $this->model->find((int)$deletePermissionId);
                    $user->revokePermissionTo($permission->name);
                }
            }    
        }

        return response($user->getAllPermissions()->toArray());
    }
}
