@extends('layout.auth')

@section('form')
<div class="login-form">
    <form action="" method="post">
        <div class="form-group">
            <label>Email Address</label>
            <input class="au-input au-input--full" type="email" name="email" value="{{ $_COOKIE['email_acc'] ?? '' }}" placeholder="Email">
            @if (session('message'))
                <small style="color: red">{{ session('message') }}</small>
            @endif
        </div>
        <div class="form-group">
            <label>Password</label>
            <input class="au-input au-input--full" type="password" name="password" value="{{ $_COOKIE['password_acc'] ?? '' }}" placeholder="Password">
        </div>
        <div class="login-checkbox">
            <label>
                <input type="checkbox" name="remember" @if(!empty($_COOKIE['email_acc'])) checked @endif>Remember Me
            </label>
            <label>
                <a href="{{ route('account.forgot') }}">Forgotten Password?</a>
            </label>
        </div>
        @csrf
        <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>
        <div class="social-login-content">
            <div class="social-button">
                <button class="au-btn au-btn--block au-btn--blue m-b-20">sign in with facebook</button>
                <a href="{{ route('account.login.Google') }}" class="au-btn au-btn--block au-btn--blue2 text-center">sign in with google</a>
            </div>
        </div>
    </form>
    <div class="register-link">
        <p>
            Don't you have account?
            <a href="{{ route('account.register') }}">Sign Up Here</a>
        </p>
    </div>
</div>
@endsection