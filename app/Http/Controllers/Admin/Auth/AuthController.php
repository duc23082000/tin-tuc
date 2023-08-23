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
use Laravel\Socialite\Facades\Socialite;


class AuthController extends Controller
{
    public function login() {
        return view('admin.auth.login');
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
            return Auth::guard('admins')->user()->role == UserRoleEnum::Admin ? redirect(route('admin.post.lists')) : redirect(route('author.post.lists'));
        }
        return back()->with('message', 'Tài khoản hoặc mật khẩu không chính xác');
    }

    public function logout(Request $request){
        Auth::guard('admins')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('login'));
    }

    public function register(){
        return view('admin.auth.register');
    }

    public function handelRegister(AuthRequest $request){
        $user = new Admin();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect(route('login'));
    }

    public function forgot(){
        return view('admin.auth.forgot');
    }

    public function sendMailReset(Request $request){
        $email = Admin::where('email', $request->input('email'))->pluck('id')->first();
        // dd($email);
        if($email){
            SendMailResetPassword::dispatch($request->only('email'));
            return back()->with(['message' => 'Vui lòng kiểm tra email đển nhận link thay đổi mật khẩu', 'color' => 'DodgerBlue']);
        }
        
        return back()->with(['message' => 'Email Không hợp lệ vui lòng kiểm tra lại', 'color' => 'red']);
    }   

    public function reset($email, $token){
        $user = ResetPassword::where('email', $email)->first();
        // dd($user);
        if(!$user) return 'email khong ton tai';

        if($user->created_at < now()->addHours(-1)){
            ResetPassword::where('email', $email)->delete();
            return redirect(route('forgot'))->with(['message' => 'Link hết hạn vui lòng nhập lại email để lấy link', 'color' => 'red']);
        }

        if(Hash::check($token, $user->token)){
            return view('admin.auth.reset');
        }
        
        return 'sai link';
    }

    public function reseting(ResetPassRequest $request){
        // dd($request->email);
        $user = Admin::where('email', $request->email)->first();
        // dd($user);
        if($user->resetPass->created_at < now()->addHours(-1)) {
            ResetPassword::where('email', $request->email)->delete();
            return redirect(route('forgot'))->with(['message' => 'Link hết hạn vui lòng nhập lại email để lấy link', 'color' => 'red']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Auth::logoutOtherDevices($request->input('password'));
        return redirect(route('login'));
    }

    public function formChange(){
        return view('admin.auth.change');
    }

    public function changePassword(ChangePasswordRequest $request){
        $user = Admin::find(app('admin_id'));
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Auth::logoutOtherDevices($request->input('current_password'));

        return redirect(route('admin.post.lists'));
    }

    public function sendMailVerify(){
        request()->user()->sendEmailVerificationNotification();

        return back();
    }

    public function verify(EmailVerificationRequest $request){
        $request->fulfill();

        return redirect('admin.post.lists');
    }

}
