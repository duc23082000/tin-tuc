@extends('layout.app')

@section('content')
<div class="card-body card-block">
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

        {{-- Title --}}
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

        {{-- Content --}}
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="editor" class=" form-control-label">Content</label>
            </div>
            <div class="col-12 col-md-9">
                <textarea name="content" id="editor" rows="9" placeholder="Content..." class="form-control">{{ old('content') }}</textarea>
            </div>
        </div>

        {{-- Users --}}
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="users">Users</label>
            </div>
            <div class="col col-md-9">
                <div class="form-check">
                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="users[]" multiple>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}-user" 
                                @selected(in_array($user->id.'-user', old('users') ?? []) )>
                                {{ $user->email }}(user)
                            </option>
                        @endforeach
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}-author" 
                                @selected(in_array($author->id.'-author', old('users') ?? []) )>
                                {{ $author->email }}(author)
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('users')
                    <small style="color: red">{{ $message }}</small>
                @enderror
                @error('user')
                    <small style="color: red">{{ $message }}</small>
                @enderror
                @error('author')
                    <small style="color: red">{{ $message }}</small>
                @enderror
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
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>


<script>
	ClassicEditor
		.create( document.querySelector( '#editor' ), {
            ckfinder: {
                uploadUrl: '{{ route('admin.post.upload'). '?_token=' . csrf_token() }}'
            }
        })
		.catch( error => {
			console.error( error );
		});
</script>

@endsection

