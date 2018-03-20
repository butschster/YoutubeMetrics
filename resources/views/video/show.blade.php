@extends('layouts.app')

@section('content')
    <div class="container">
        <header id="video-header" class="card bg-dark text-white rounded-0 mt-5">
            <div class="cover" style="background-image: url({{ $video->thumb }});"></div>
            <div class="card-img-overlay container">
                <div class="d-flex justify-content-center">
                    <div class="align-self-center text-center">

                        <h1 class="card-title">{{ $video->title }}</h1>

                        <div class="btn-group my-4" role="group">
                            <a class="btn btn-outline-light" href="{{ route('channel.show', $video->channel_id) }}"
                               target="_blank">
                                <i class="far fa-user-circle"></i> {{ $video->channel->name ?? $video->channel_id }}
                            </a>

                            <a class="btn btn-outline-light" href="https://www.youtube.com/watch?v={{ $video->id }}"
                               target="_blank">
                                <i class="fab fa-youtube"></i> Посмотреть видео
                            </a>
                        </div>
                    </div>
                </div>

                @if($tags->count() > 0)
                    <div class="text-center p-3">
                        @foreach($tags as $tag)
                            <span class="badge badge-light">{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        </header>

        <div class="bg-dark py-3 text-center text-white">
            @include('video._partials.counters')
        </div>
        <video-chart id="{{ $video->id }}"></video-chart>
    </div>
    <div class="container mt-5">
        <video-comments id="{{ $video->id }}" class="my-5"></video-comments>
    </div>
@endsection
