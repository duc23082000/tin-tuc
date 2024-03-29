<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ResetPassRequest;
use App\Jobs\SendMailResetPassword;
use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class Authcontroller extends Controller
{
    public function login() {
        return view('client.auth.login');
    }

    public function handelLogin(Request $request){

        $user = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        
        if(Auth::guard('web')->attempt($user)){
            if($request->remember){
                setcookie('email_acc', $request->input('email'), time()+(10*24*60*60));
                setcookie('password_acc', $request->input('password'), time()+(10*24*60*60));
            } else {
                setcookie('email_acc', "");
                setcookie('password_acc', "");
            }
            return response()->json(['success' => 'Login thành công']);
        }
        return response()->json(['fail' => 'Tài khoản hoặc mật khẩu không chính xác'], 401);
    }

    public function logout(Request $request){
        Auth::guard('web')->logout();
        return redirect(route('login'));
    }

    public function register(){
        return view('client.auth.register');
    }

    public function handelRegister(AuthRequest $request){
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect(route('account.login'));
    }

    public function forgot(){
        return view('client.auth.forgot');
    }

    public function sendMailReset(Request $request){
        $email = User::where('email', $request->input('email'))->pluck('id')->first();
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
            return redirect(route('account.forgot'))->with(['message' => 'Link hết hạn vui lòng nhập lại email để lấy link', 'color' => 'red']);
        }

        if(Hash::check($token, $user->token)){
            return view('admin.auth.reset');
        }
        
        return 'sai link';
    }

    public function reseting(ResetPassRequest $request){

        $token_reset = ResetPassword::where('email', $request->email)->first();
        // dd($token_reset->delete());
        if($token_reset->created_at < now()->addHours(-1)) {
            ResetPassword::where('email', $request->email)->delete();
            return redirect(route('account.forgot'))->with(['message' => 'Link hết hạn vui lòng nhập lại email để lấy link', 'color' => 'red']);
        }
        
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        ResetPassword::where('email', $request->email)->delete();
        // Auth::logoutOtherDevices($request->input('password'));
        return redirect(route('account.login'));
    }

    public function formChange(){
        return view('admin.auth.change');
    }

    public function changePassword(ChangePasswordRequest $request){
        $user = User::find(Auth::guard('web')->user()->id);
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Auth::guard('web')->logoutOtherDevices($request->input('current_password'));

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

    // Đăng nhập bằng google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Xử lí đăng nhập bằng google
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        $email = $user->email;
        $username = $user->name;

        $select = User::where('email', $email)->first();
        // dd($select->id);

        if(empty($select)){
            $newUser = new User();
            $newUser->username = $username;
            $newUser->email = $email;
            $newUser->password = '';
            $newUser->save();
            Auth::guard('web')->loginUsingId($newUser->id);
            return redirect(route('home'));
        }

        Auth::guard('web')->loginUsingId($select->id);
        return redirect(route('home'));
    }
}
