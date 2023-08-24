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
        <h1 class="mb-4">{{ $post->title }}</h1>
        <div class="mb-3">
            <div class="card-body">
                <div class="default-tab">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active show" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fa fa-home" aria-hidden="true"></i></a>
                            <a class="nav-item nav-link" href="{{ route('like', [$post->id]) }}">
                                @auth
                                    @if ($post->likes->contains(Auth::user()->id))
                                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                    @else
                                        <i class="far fa-thumbs-up"></i>
                                    @endif
                                @endauth
                                @guest
                                    <i class="far fa-thumbs-up"></i>
                                @endguest
                                {{ count($post->likes) }}
                            </a>
                            <a class="nav-item nav-link" id="nav-comment-tab" data-toggle="tab" href="#nav-comment" role="tab" aria-controls="nav-comment" aria-selected="false"><i class="fa fa-comments" aria-hidden="true"></i></a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false"><i class="fa fa-compress" aria-hidden="true"></i></a>
                        </div>
                    </nav>
                    <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <p>{!! $post->content !!}</p>
                        </div>
                        <div class="tab-pane fade mt-3" id="nav-comment" role="tabpanel" aria-labelledby="nav-comment-tab">
                            @foreach ($comments as $comment)
                                <p class="mb-4"><a href="#">{{ $comment->commented_by->username }}</a>: {{ $comment->content }}</p>
                            @endforeach
                            <form action="{{ route('comment', $post->id) }}" method="post">
                                <div class="input-group mb-2">
                                    <div class="input-group-addon">
                                        <textarea name="comment" placeholder="Chia sẻ ý kiến của bạn" style="width: 1000px; height: 76px;"></textarea>
                                    </div>
                                </div>
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Gửi</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth
                                master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh
                                dreamcatcher synth. Cosby sweater eu banh mi, irure terry richardson ex sd. Alip placeat salvia cillum iphone.
                                Seitan alip s cardigan american apparel, butcher voluptate nisi .</p>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
        <p></p>
    </div>
    
@endsection

@section('script')
    <script>

    </script>
@endsection