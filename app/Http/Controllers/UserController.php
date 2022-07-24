<?php

namespace App\Http\Controllers;

use App\Mail\VirfyAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    //

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            abort(434, "لا يوجد حساب بهذا الإيميل");
        } else {
            $checkPassword = Hash::check($request->password, $user->password);
            if (!$checkPassword) {
                abort(434, "كلمة المرور غير صحيحه");
            } else {
                return response()->json([
                    'id' => $user->id,
                    'token' => $user->createToken($request->email)->plainTextToken,
                    'phoneNumber' => $user->phoneNumber,
                    'email' => $user->email,
                    'image' => $user->image,
                    'userName' => $user->userName,
                ]);
            }
        }
    }

    public function signup(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {

            $result = strval(rand(111111, 999999));

            $request->validate([
                ///name of request => 'unique: table name ,column name ';
                'email' => 'unique:customer,email|email'
            ]);

            $confirmCode = User::create([
                'userName' => $request->userName,
                'phoneNumber' => $request->phoneNumber,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'confirm_code' => strval($result),
                'blocked' => 0
            ]);
            return response()->json('تم إنشاء الحساب بنجاح');
        } else {
            abort(430, "هذا الايميل مستخدم مسبقاً");
        }
    }


    public function checkUser(Request $request)
    {
        return response()->json(['user' => $request->user(), 'isAuth' => Auth::check()]);
    }

    public function confirmCode(Request $request)
    {
        $user = User::where('email', $request->email)->where('confirm_code', $request->confirm_code)->first();
        if ($user) {
            return response()->json('تم التحقق بنجاح');
        } else {
            abort(430, "لا يوجد تطابق بالبيانات");
        }
    }

    public function restorePassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $password = $user->password = bcrypt($request->password);

            return response()->json('ok');
        } else {
            abort(430, "هذا الايميل مستخدم مسبقاً");
        }
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json('تم تسجيل الخروج بنجاح.');
    }



    public function editUserDetails(Request $request)
    {

        $token = PersonalAccessToken::findToken($request->api_token);
        $userToken = $token->tokenable;

        $user = User::where('id', $userToken->id)->first();
        $user->update([
            'userName' => $request->userName,
            'phoneNumber' => $request->phoneNumber,
            'email' => $request->email,
            // 'image' => $request->imageChanged == 'yes' ? ImageController::uploadImageBase64($request->image, 'usersImages') : $request->image,
            'password' => bcrypt($request->password),

        ]);

        return response()->json([
            'id' => $user->id,
            'token' => $request->api_token,
            'phoneNumber' => $user->phoneNumber,
            'image' => $user->image,
            'userName' => $user->userName,
            'email' => $user->email
        ]);
    }
    public function sendVirfyCode(Request $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();
        $number = rand(111111, 999999);
        $user->virfy_code = $number;
        $user->save();
        Mail::to($user)->send(new VirfyAccount($number));
        return response()->json('تم ارسال الرمز بنجاح');
    }
}
