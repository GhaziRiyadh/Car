<?php

namespace App\Http\Controllers\Dashboard\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UsersRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class UsersController extends Controller
{

    /**
     * @param null $name
     * @param null $id
     * @param null $type
     * @return Collection|array|\Illuminate\Support\Collection
     */
    public static function getUsers($name = null, $id = null, $type = null)
    {
        return User::query()
            ->when($name, fn ($q, $r) => $q->where('name', 'like', '%' . $r . '%'))
            ->when($id, fn ($q, $r) => $q->where('id', '=', $r))
            ->when($type, fn ($q, $r) => $q->whereRelation('roles', 'display_name', 'like', $r))
            ->get()->map(function ($v) {
                $permissions = $v->roles()->get()->map(function ($v) {
                    return $v->permissions()->get()->map(fn ($v) => $v['name']);
                });
                $userRole = $v->roles()->get()->map(fn ($r) => $r['name']);
                return [
                    'id' => $v['id'],
                    'name' => $v['name'],
                    'permissions' => $permissions,
                    'email' => $v['email'],
                    'phone' => $v['phone'],
                    'type' => $userRole,
                ];
            });
    }

    public function store(UsersRequest $request): JsonResponse
    {
        $data = $request->safe()->except('roles');
        $user = User::query()->create($data);
        foreach ($request->roles as $role => $value)
            if ($value)
                $user->attachRole($role);


        return response()->json(self::getUsers(null, $user->id));
    }


    public function update(UsersRequest $request, User $id): JsonResponse
    {
        $data = $request->safe()->except(['roles', 'password']);
        $roles = collect($request->roles)->filter(fn ($v) => $v)->keys();
        $id->update($data);
        $id->syncRoles($roles);

        return response()->json(self::getUsers(id: $id->refresh()->id));
    }

    public function delete(User $id): JsonResponse
    {
        $id->delete();
        return response()->json('done');
    }

    public function changeStatus(User $user, bool $status): JsonResponse
    {
        $user->update(['blocked' => $status]);

        return response()->json([
            'status' => $status,
            'message' => 'User status changed',
        ]);
    }

    public function statusCount(): JsonResponse
    {
        $count = Role::where('id', '>', 1)->get()->map(fn ($v) => ['name' => $v->display_name, 'count' => User::whereRelation('roles', 'name', '=', $v->name)->count()])->toArray();

        return response()->json($count);
    }
}
