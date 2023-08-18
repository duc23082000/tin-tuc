@extends('layout.auth')

@section('form')
<div class="login-form">
    <form action="" method="post">
        <div class="form-group">
            <label>Current Password</label>
            <input class="au-input au-input--full" type="password" name="current_password" placeholder="Password">
            @error('current_password')
                <small style="color: red">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Password</label>
            <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
            @error('password')
                <small style="color: red">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input class="au-input au-input--full" type="password" name="cfpassword" placeholder="Confirm Password">
        </div>
        @csrf
        <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">submit</button>
    </form>
</div>
@endsection