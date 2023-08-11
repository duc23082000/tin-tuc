@extends('layout.app')

@section('content')
    @foreach ($posts as $post)
        <h3>{{ $post->title }}</h3>
        <div class="ml-5">
            <p>{{ $post->content }}</p>
        </div>
    @endforeach
    <div class="d-flex justify-content-end">
        {{ $posts->links('pagination.simple-tailwind') }}
    </div>
@endsection