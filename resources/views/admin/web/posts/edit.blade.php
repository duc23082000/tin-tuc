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
                <input type="text" id="text-input" name="title" value="{{ old('title') ?? $post->title }}" placeholder="Title..." class="form-control">
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
                <textarea name="content" id="editor" rows="9" placeholder="Content..." class="form-control">{{ old('content') ?? $post->content }}</textarea>
            </div>
        </div>

        {{-- Status --}}
        <div class="row form-group">
            <div class="col col-md-3">
                <label class=" form-control-label">Status</label>
            </div>
            <div class="col col-md-9">
                <div class="form-check">
                    @foreach ($status as $item)
                        <div class="radio">
                            <label for="radio1" class="form-check-label ">                             
                                <input type="radio" id="radio1" name="status" value="{{ $item }}" class="form-check-input" 
                                @checked($item == (old('status') ?? $post->status ))>{{ $statusName[$item] }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('status')
                    <small style="color: red">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Categories --}}
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="tags">Categories</label>
            </div>
            <div class="col col-md-9">
                <div class="form-check">
                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="category">
                        <option>Chọn danh mục</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                @selected($category->id == (old('category') ?? $post->category->id))>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('category')
                    <small style="color: red">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Tags --}}
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="tags">Tags</label>
            </div>
            <div class="col col-md-9">
                <div class="form-select">
                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="tags[]" multiple>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" 
                                @selected(in_array($tag->id, old('tags') ?? $post->tags->pluck('id')->toArray()))>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('tags')
                    <small style="color: red">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Posted at --}}
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="posted_at" class=" form-control-label">Posted at</label>
            </div>
            <div class="col-12 col-md-9">
                <input type="date" id="posted_at" name="posted_at" value="{{ old('posted_at') ?? $post->posted_at }}" class="form-control">
                @error('posted_at')
                    <small style="color: red">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- File Image --}}
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="file-multiple-input" class=" form-control-label">Multiple File input</label>
            </div>
            <div class="col-12 col-md-9">
                <input type="file" id="file-multiple-input" name="image" multiple="" class="form-control-file">
                @error('image')
                    <small style="color: red">{{ $message }}</small>
                @enderror
                @if (!empty($post->image))
                    <div style="width: 30%; height: auto;">
                        <img src="{{ asset('storage/images/' .$post->image) }}" alt="1">
                    </div>
                @endif
            </div>
        </div>

        <div class="row form-group">
            <div class="col col-md-3"></div>
            <div class="col-12 col-md-9">
                @csrf
                @method('PUT')
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