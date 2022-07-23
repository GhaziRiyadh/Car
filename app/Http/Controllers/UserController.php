<?php

namespace App\Http\Controllers;

use App\Mail\VirfyAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    //

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
            // 'virfy_code' => 'required|exists:users,virfy_code'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['أوراق الاعتماد المقدمة غير صحيحة.'],
            ]);
        }

        $token = $user->createToken($request->device_name);
        return response()->json([
            'token' => $token->plainTextToken,
            'user' => $user,
            'userType' => $user->roles()?->first()?->name,
        ], 200);
    }

    public function checkUser(Request $request)
    {
        return response()->json(['user' => $request->user(), 'isAuth' => Auth::check()]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json('تم تسجيل الخروج بنجاح.');
    }

    public function virfyAccount(Request $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();
        $number = rand(111111, 999999);
        $user->virfy_code = $number;
        $user->save();
        Mail::to($user)->send(new VirfyAccount($number));
        return response()->json('تم ارسال الرمز بنجاح');
    }
}
