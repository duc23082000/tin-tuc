@extends('layout.app')

@section('content')
<div class="card-body card-block">
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="text-input" class=" form-control-label">Name</label>
            </div>
            <div class="col-12 col-md-9">
                <input type="text" id="text-input" name="name" value="{{ old('name') ?? $tag->name }}" placeholder="Name..." class="form-control">
                @error('name')
                    <small style="color: red">{{ $message }}</small>
                @enderror
            </div>     
        </div>  
        <div class="row form-group">
            <div class="col col-md-3"></div>
            <div class="col-12 col-md-9">
                <input type="hidden" name="id" value="{{ $tag->id }}">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa fa-dot-circle-o"></i> Submit
                </button>
                <a href="{{ route('admin.tag.lists') }}" class="btn btn-danger  btn-sm">
                    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Back
                </a>
            </div>
        </div>
    </form>
</div>
@endsection