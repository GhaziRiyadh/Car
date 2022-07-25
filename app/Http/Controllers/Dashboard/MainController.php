<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Content\AppInfoController;
use App\Http\Controllers\Dashboard\Content\BillController;
use App\Http\Controllers\Dashboard\Content\CarController;
use App\Http\Controllers\Dashboard\Content\CompanyController;
use App\Http\Controllers\Dashboard\Content\ProductController;
use App\Http\Controllers\Dashboard\Content\UsersController;
use App\Http\Controllers\Dashboard\Users\PermissionController;
use App\Http\Controllers\Dashboard\Users\RoleController;
use App\Models\BillStatus;
use App\Models\Car;
use App\Models\Company;
use App\Models\Quality;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function getRecords(Request $request): JsonResponse
    {
        $type = $request->get('type');
        $name = $request->get('name') == '' ? null : $request->get('name');

        $data = match ($type) {

            'COMPANY', 'CONTENT' => [
                'data' => CompanyController::getCompany(name: $name),
                'roles' => [],
            ],

            'CARS' => [
                'data' => CarController::getCars(name: $name),
                'roles' => [
                    'company' => Company::all(['id', 'name']),
                ],
            ],

            'PRODUCT' => [
                'data' => ProductController::getProducts(name: $name),
                'roles' => [
                    'car' => Car::all(['id', 'name']),
                    'quality' => Quality::all(['id', 'name']),
                ],
            ],


            'BILL' => [
                'data' => BillController::getBills(name: $name),
                'roles' => [
                    'status' => BillStatus::all(['id', 'name']),
                ],
            ],

            // APP management
            'APP_MANAGEMENT', 'APP_USERS' => [
                'data' => UsersController::getUsers(name: $name),
                'roles' => []
            ],

            'APP_INFO' => [
                'data' => AppInfoController::getAppIngo(name: $name),
                'roles' => [],
            ],

                // users
                // 'USER', 'USERS' => [
                //     'data' => UsersController::getUsers($name, type: 'admin'),
                //     'roles' => RoleController::getRole(),
                // ],
                // 'ROLE' => [
                //     'data' => RoleController::getRole(name: $name),
                //     'roles' => PermissionController::getPermission(),
                // ],
                // 'PERMISSION' => [
                //     'data' => PermissionController::getPermission($name),
                //     'roles' => RoleController::getRole(),
                // ],
            default => [
                'data' => [],
                'roles' => [],
            ]
        };

        return response()->json($data);
    }
}
