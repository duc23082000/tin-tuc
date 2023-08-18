@extends('layout.auth')

@section('css')
    <style>
        .input {
            
        }
    </style>
@endsection

@section('form')
<div class="login-form">
    <form action="" method="post">
        <div class="form-group">
            <label>User name</label>
            <input class="au-input au-input--full" type="text" name="username"
                value="{{ old('username') }}" placeholder="User name">
            @error('username')
                <small style="color: red; fontsize: 0.7em;">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Email Address</label>
            <input class="au-input au-input--full" type="email" name="email" 
                value="{{ old('email') }}" placeholder="Email">
            @error('email')
                <small style="color: red; fontsize: 0.7em;">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Password</label>
            <input class="au-input au-input--full" type="password" name="password"
                placeholder="Password">
            @error('password')
                <small style="color: red; fontsize: 0.7em;">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input class="au-input au-input--full" type="password" name="cfpassword" 
                placeholder="Confirm Password">
            @error('cfpassword')
                <small style="color: red; fontsize: 0.7em;">{{ $message }}</small>
            @enderror
        </div>
        @csrf
        <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">submit</button>
        <div class="social-login-content">
            <div class="social-button">
                <button class="au-btn au-btn--block au-btn--blue m-b-20">sign in with facebook</button>
                <button class="au-btn au-btn--block au-btn--blue2">sign in with twitter</button>
            </div>
        </div>
    </form>
    <div class="register-link">
        <p>
            You have account?
            <a href="{{ route('login') }}">Login Here</a>
        </p>
    </div>
</div>
@endsection