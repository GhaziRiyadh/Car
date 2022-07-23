<?php

use App\Http\Controllers\Api\FrontEndController;
use App\Http\Controllers\Dashboard\Users\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json(['user' => $request->user()]);
    // return Storage::download('/storage/app/test/s0314gqWZKmijcryHJPEVrixuU6RToPH0h1GQJs0.jpg');
});

Route::get('/get-file', function (Request $request) {
    // return response()->json(['path' => $request->file('file')->store('test')]);
    return response()->download(public_path('Files/test/1.pdf'), '1.pdf');
});

// login
Route::post('api-login', [UserController::class, 'login']);
// Route::post('sure-login', [UserController::class, 'login']);

Route::post('check-user', [UserController::class, 'checkUser']);


// TODO: to use forget password mainUrl 'forget-password'


Route::middleware(['auth:sanctum'])->group(function () {
    // logout
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('get-subject', [FrontEndController::class, 'getSubject']);
    Route::get('set-subject-file', [FrontEndController::class, 'setSubjectFile']);
    Route::get('set-student-by-level', [FrontEndController::class, 'getStudentByLevel']);
});


// للطلاب يتم اظافة الروابط هنا
// /api/student/-your urls-
Route::middleware('role:student')->prefix('student')->group(function () {
    //
});

// للمدرسين يتم اظافة الروابط هنا
// /api/teacher/-your urls-
Route::middleware('role:teacher')
    ->controller(FrontEndController::class)
    ->prefix('teacher')
    ->group(function () {
        //
    });


/**
 * this function will return subject with course as
 * [{
 *      id:subjectId,
 *      name:subjectName,
 *      file:subjcetFile,
 *      course:[{
 *          id:courseId,
 *          name:courseName,
 *          start_date:courseStartDate,
 *          end_date:courseEndDate,
 *          type:{
 *              id:typeId,
 *              type:type,
 *          },
 *      }]
 * }]
 * You have to handling in front end
 *
 * @return JsonResponse
 */
Route::get('get-subject-with-course', [FrontEndController::class, 'getSubjectWithLevel']);

// return user type
Route::post('users-roles', function (Request $request) {
    return response()->json(RoleController::getRole());
});