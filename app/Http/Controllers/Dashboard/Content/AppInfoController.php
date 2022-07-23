<?php

namespace App\Http\Controllers\Dashboard\Content;

use App\Http\Controllers\Controller;
use App\Models\AppInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppInfoController extends Controller
{
    public static function getAppIngo($id = null, $name = null): Collection|array
    {
        return AppInfo::query()
            ->when($id, fn ($query, $id) => $query->where('id', '=', $id))
            ->get(['id', 'address', 'aboutUs', 'phone', 'email']);
    }

    /**
     * @param Request $request
     * @param AppInfo $appInfo
     * @return JsonResponse
     */
    public function update(Request $request, AppInfo $appInfo): JsonResponse
    {
        $data = $request->validate([
            'aboutUs' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ]);
        $appInfo->update($data);
        return response()->json(self::getAppIngo($appInfo->id));
    }
}
