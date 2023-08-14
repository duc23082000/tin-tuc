@extends('layout.app')

@section('content')
<div class="card-body card-block">
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="text-input" class=" form-control-label">User Name</label>
            </div>
            <div class="col-12 col-md-9">
                <input type="text" id="text-input" name="username" value="{{ old('username') ?? $user->username }}" placeholder="User name..." class="form-control">
                @error('username')
                    <small style="color: red">{{ $message }}</small>
                @enderror
            </div>     
        </div>
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="text-input" class=" form-control-label">Email</label>
            </div>
            <div class="col-12 col-md-9">
                <input type="text" id="text-input" name="email" value="{{ old('email') ?? $user->email }}" placeholder="Email..." class="form-control">
                @error('email')
                    <small style="color: red">{{ $message }}</small>
                @enderror
            </div>     
        </div>
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="text-input" class=" form-control-label">Password</label>
            </div>
            <div class="col-12 col-md-9">
                <input type="password" id="text-input" name="password" value="{{ old('password') }}" placeholder="Password..." class="form-control">
                @error('password')
                    <small style="color: red">{{ $message }}</small>
                @enderror
            </div>     
        </div>
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="text-input" class=" form-control-label">Confirm Password</label>
            </div>
            <div class="col-12 col-md-9">
                <input type="password" id="text-input" name="cfpassword" value="{{ old('cfpassword') }}" placeholder="Confirm Password..." class="form-control">
                @error('cfpassword')
                    <small style="color: red">{{ $message }}</small>
                @enderror
            </div>     
        </div>   
        <div class="row form-group">
            <div class="col col-md-3"></div>
            <div class="col-12 col-md-9">
                <input type="hidden" name="id" value="{{ $user->id }}">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa fa-dot-circle-o"></i> Submit
                </button>
                <a href="{{ route('admin.user.lists') }}" class="btn btn-danger  btn-sm">
                    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Back
                </a>
            </div>
        </div>
    </form>
</div>
@endsection