@extends('layout.app')

@section('content')
<div class="card-body card-block">
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="text-input" class=" form-control-label">title</label>
            </div>
            <div class="col-12 col-md-9">
                <input type="text" id="text-input" name="title" value="{{ old('title') }}" placeholder="Title..." class="form-control">
                @error('title')
                    <small style="color: red">{{ $message }}</small>
                @enderror
            </div>     
        </div>
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="textarea-input" class=" form-control-label">Content</label>
            </div>
            <div class="col-12 col-md-9">
                <textarea name="content" id="textarea-input" rows="9" placeholder="Content..." class="form-control">{{ old('content') }}</textarea>
            </div>
        </div>
        <div class="row form-group">
            <div class="col col-md-3">
                <label class=" form-control-label">Status</label>
            </div>
            <div class="col col-md-9">
                <div class="form-check">
                    @foreach ($status as $item)
                        <div class="radio">
                            <label for="radio1" class="form-check-label ">
                                <input type="radio" id="radio1" name="status" value="{{ $item }}" class="form-check-input" @if($item == old('status')) checked @endif>{{ $statusName[$item] }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('status')
                    <small style="color: red">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="posted_at" class=" form-control-label">Posted at</label>
            </div>
            <div class="col-12 col-md-9">
                <input type="date" id="posted_at" name="posted_at" class="form-control">
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
                <a href="{{ route('admin.post.lists') }}" class="btn btn-danger  btn-sm">
                    <i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Back
                </a>
            </div>
        </div>
    </form>
</div>
@endsection