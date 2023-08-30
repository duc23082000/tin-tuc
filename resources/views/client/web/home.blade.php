@extends('layout.app-client')

@section('content')
    <div class="container">
        @foreach ($posts as $post)
        <div class="row mb-4">
            <div class="col-md-3" style="height: 180px">
                <img src="{{ asset('storage/images/'.$post->image) }}" style="width: 300px; height: 180px;" alt="img">
            </div>
            <div class="col-md-9">
                <a href="{{ route('show', [$post->id]) }}">
                    <h3>{{ $post->title }}</h3>
                </a>
            </div> 
        </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-end">
        {{ $posts->links('pagination.simple-tailwind') }}
    </div>
@endsection