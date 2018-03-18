@extends('layouts.app')

@section('content')
    <header id="author-header" class="card text-center text-white author-type-{{ $author->type() }}">
        @if($author->thumb)
        <div class="author-cover" style="background-image: url({{ $author->thumb }});"></div>
        @endif

        <div class="card-img-overlay d-flex justify-content-center">
            <div class="align-self-center text-center">
                <h1 class="card-title">{{ $author->name }}</h1>
                <h3>{{ trans('author.type.'.$author->type()) }}</h3>

                <div>
                    <span class="badge badge-light">ID: <strong>{{ $author->id }}</strong></span>
                </div>

                <div class="btn-group my-4" role="group">

                    <a class="btn btn-outline-light" href="https://www.youtube.com/channel/{{ $author->id }}" target="_blank">
                        <i class="fab fa-youtube fa-fw fa-lg"></i> Канал
                    </a>

                    <a class="btn btn-outline-light" href="https://www.t30p.ru/search.aspx?s={{ $author->id }}" target="_blank">
                        <i class="fab fa-lg fa-fw fa-searchengin"></i> Поиск комментариев
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        @if($videos->count() > 0)
        <div class="row mt-5">
            @foreach($videos as $video)
                @include('video._partials.row', ['video' => $video, 'colSize' => 'col-md-4'])
            @endforeach
        </div>

        {!! $videos->render() !!}
        @endif

        <author-comments id="{{ $author->id }}" class="my-5"></author-comments>
    </div>
@endsection