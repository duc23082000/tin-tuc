@extends('layout.app')

@section('content')
    @foreach ($posts as $post)
        <h3>{{ $post->title }}</h3>
        {{-- <img src="{{ asset }}" alt="img"> --}}
    @endforeach
    <div class="d-flex justify-content-end">
        {{ $posts->links('pagination.simple-tailwind') }}
    </div>
@endsection