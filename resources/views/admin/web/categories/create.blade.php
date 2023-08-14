@extends('layout.app')

@section('content')
<div class="card-body card-block">
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="text-input" class=" form-control-label">Name</label>
            </div>
            <div class="col-12 col-md-9">
                <input type="text" id="text-input" name="name" value="{{ old('name') }}" placeholder="Name..." class="form-control">
                @error('name')
                    <small style="color: red">{{ $message }}</small>
                @enderror
            </div>     
        </div>
        </div>
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="file-multiple-input" class=" form-control-label">Multiple File input</label>
            </div>
            <div class="col-12 col-md-9">
                <input type="file" id="file-multiple-input" name="file-multiple-input" multiple="" class="form-control-file">
            </div>
        </div>
        <div class="row form-group">
            <div class="col col-md-3"></div>
            <div class="col-12 col-md-9">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa fa-dot-circle-o"></i> Submit
                </button>
                <a href="{{ route('admin.category.lists') }}" class="btn btn-danger  btn-sm">
                    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Back
                </a>
            </div>
        </div>
    </form>
</div>
@endsection