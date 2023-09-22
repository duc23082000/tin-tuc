<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ResetPassRequest;
use App\Jobs\SendMailResetPassword;
use App\Models\ResetPassword;
use App\Models\Admin;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;


class AuthController extends Controller
{
    public function login() {
        return Inertia::render('admins/auth/Login');
    }

    public function handelLogin(Request $request){

        $user = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if(Auth::guard('admins')->attempt($user)){
            if($request->remember){
                setcookie('email', $request->input('email'), time()+(10*24*60*60));
                setcookie('password', $request->input('password'), time()+(10*24*60*60));
            } else {
                setcookie('email', "");
                setcookie('password', "");
            }
            return Auth::guard('admins')->user()->role == UserRoleEnum::Admin ? response()->json([
                'url' => route('admin.category.lists')
            ]) : response()->json([
                'url' => route('author.post.lists')
            ]);
        }
        return response()->json([
            'message' => 'Tài khoản hoặc mật khẩu không chính xác'
        ], 401);
    }

    public function logout(Request $request){
        Auth::guard('admins')->logout();

        return redirect(route('admin.login'));
    }

}
