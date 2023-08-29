@extends('layout.app')

@section('style')
    <style>
        .image{
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <h1 class="mb-4">{{ $notification->data['title'] }}</h1>
        <div class="mb-3">
            <div class="card-body">
                {!! $notification->data['content'] !!}        
            </div>
        </div>
    </div>
    
@endsection

@section('script')
    <script>

    </script>
@endsection