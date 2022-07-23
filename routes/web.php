<?php

use App\Http\Controllers\Dashboard\Content\AppInfoController;
use App\Http\Controllers\Dashboard\Content\BillController;
use App\Http\Controllers\Dashboard\Content\CarController;
use App\Http\Controllers\Dashboard\Content\CompanyController;
use App\Http\Controllers\Dashboard\Content\ProductController;
use App\Http\Controllers\Dashboard\Content\UsersController;
use App\Http\Controllers\Dashboard\MainController;
use App\Http\Controllers\Dashboard\Users\PermissionController;
use App\Http\Controllers\Dashboard\Users\RoleController;
use App\Models\BillStatus;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware([
    'auth:sanctum',
    'role:admin',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/profile', function () {
        $user = User::first();
        return Inertia::render('Dashboard');
    })->name('profile');


    Route::middleware('role:admin')->group(function () {

        // start for user management api
        Route::prefix('users')
            ->controller(UsersController::class)
            ->name('user.')
            ->group(function () {
                Route::post('update/{id}', 'update')->name('update');
                Route::post('store', 'store')->name('store');
                Route::get('delete/{id}', 'delete')->name('delete');
            });

        Route::prefix('role')
            ->controller(RoleController::class)
            ->name('role.')
            ->group(function () {
                Route::post('update/{role:id}', 'update')->name('update');
                Route::post('store', 'store')->name('store');
                Route::get('delete/{role:id}', 'delete')->name('delete');
            });

        Route::prefix('permission')
            ->controller(PermissionController::class)
            ->name('permission.')
            ->group(function () {
                Route::post('update/{permission:id}', 'update')->name('update');
                Route::post('store', 'store')->name('store');
                Route::get('delete/{permission:id}', 'delete')->name('delete');
            });
        // end for user management api

        Route::post('get-records', [MainController::class, 'getRecords'])->name('main.getRecords');


        Route::prefix('car')->name('car.')->controller(CarController::class)->group(function () {
            Route::post('update/{car}', 'update')->name('update');
            Route::post('store', 'store')->name('store');
            Route::get('delete/{car}', 'delete')->name('delete');
        });

        Route::prefix('product')->name('product.')->controller(ProductController::class)->group(function () {
            Route::post('update/{product}', 'update')->name('update');
            Route::post('store', 'store')->name('store');
            Route::get('delete/{product}', 'delete')->name('delete');
        });

        Route::prefix('company')->name('company.')->controller(CompanyController::class)->group(function () {
            Route::post('update/{company}', 'update')->name('update');
            Route::post('store', 'store')->name('store');
            Route::get('delete/{company}', 'delete')->name('delete');
        });

        Route::prefix('bill')->name('bill.')->controller(BillController::class)->group(function () {
            Route::get('change-status/{bill}/{state}', 'changeStatus')->name('billChangeStatus');
            Route::get('status-count', 'statusCount')->name('billStatusCount');
            Route::get('get-bills/{status:name}', function (BillStatus $status){
                return BillController::getBills(status: $status->id)->toJson();
            })->name('getBills');
        });

        Route::prefix('appUsers')->name('appUsers.')->controller(UsersController::class)->group(function () {
            Route::get('change-status/{user}/{status}', 'changeStatus')->name('appUsersChangeStatus');
            Route::get('status-count', 'statusCount')->name('appUsersStatusCount');
            Route::get('get-users/{type}', function ($type){
                return UsersController::getUsers(type: $type)->toJson();
            })->name('getUsers');
        });

        // for app info
        Route::post('app-info/update/{appInfo}', [AppInfoController::class, 'update'])->name('app_info.update');

    });
});
