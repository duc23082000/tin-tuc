@extends('layout.auth')

@section('form')
<div class="login-form">
    <form action="" method="post">
        <div class="form-group">
            <label>Email Address</label>
            <input class="au-input au-input--full" type="text" name="email" value="{{ old('email') }}" placeholder="Email">
            @if (session('message'))
                <small style="color: {{ session('color') }}">{{ session('message') }}</small>
            @endif
        </div>
        @csrf
        <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">submit</button>
    </form>
    <div class="register-link">
        <p>
            Login account?
            <a href="{{ route('login') }}">Log in</a>
        </p>
    </div>
</div>
@endsection