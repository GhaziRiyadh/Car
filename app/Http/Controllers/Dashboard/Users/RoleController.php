<?php

namespace App\Http\Controllers\Dashboard\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\RoleAndPermission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public static function getRole($name = null, $id = null)
    {
        return Role::with('permissions:id,name')
            ->when($name, fn ($q, $r) => $q->where('name', 'like', '%' . $r . '%'))
            ->when($id, fn ($q, $r) => $q->where('id', $r))
            ->get(['id', 'name', 'display_name'])
            ->map(function ($v) {
                return [
                    'id' => $v['id'],
                    'name' => $v['name'],
                    'permissions' => collect($v['permissions'])->map(fn ($v) => [$v['id'] => $v['name']])->toArray()
                ];
            });
    }

    public function update(RoleAndPermission $request, Role $role)
    {
        $role->update($request->validated());

        $roles_id = collect($request->permissions)->filter(fn ($v) => $v == true)->keys();

        $role->permissions()->sync($roles_id);

        return response()->json(self::getRole(null, $role->id));
    }

    public function store(RoleAndPermission $request)
    {
        $role = Role::create($request->validated());

        $roles_id = collect($request->permissions)->filter(fn ($v) => $v == true)->keys();

        $role->permissions()->sync($roles_id);

        return response()->json(self::getRole(null, $role->id));
    }

    public function delete(Role $role)
    {
        $role->delete();
        return response()->json('done');
    }
}
