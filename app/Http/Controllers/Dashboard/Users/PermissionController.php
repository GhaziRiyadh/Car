<?php

namespace App\Http\Controllers\Dashboard\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\RoleAndPermission;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public static function getPermission($name = null, $id = null)
    {
        return Permission::with('roles:id,name')
            ->when($name, fn ($q, $r) => $q->where('name', 'like', '%' . $r . '%'))
            ->when($id, fn ($q, $r) => $q->where('id', '=', $r))
            ->get(['id', 'name'])
            ->map(function ($v) {
                return [
                    'id' => $v['id'],
                    'name' => $v['name'],
                    'roles' => collect($v['roles'])->map(fn ($v) => [$v['id'] => $v['name']])->toArray()
                ];
            });
    }
    public function update(RoleAndPermission $request, Permission  $permission)
    {
        $permission->update($request->validated());

        $roles_id = collect($request->roles)->filter(fn ($v) => $v == true)->keys();

        $permission->roles()->sync($roles_id);

        return response()->json(self::getPermission(null, $permission->id));
    }

    public function store(RoleAndPermission $request)
    {
        $permission = Permission::query()->create($request->validated());

        $roles_id = collect($request->roles)->filter(fn ($v) => $v == true)->keys();

        $permission->roles()->sync($roles_id);

        return response()->json(self::getPermission(null, $permission->id));
    }

    public function delete(Permission $permission)
    {
        $permission->delete();
        return response()->json('done');
    }
}
