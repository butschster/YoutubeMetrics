@extends('layouts.app')

@section('content')
    <header id="video-header" class="card bg-dark text-white rounded-0">
        <div class="video-cover" style="background-image: url({{ $video->thumb }});"></div>
        <div class="card-img-overlay d-flex justify-content-center">
            <div class="align-self-center text-center">
                <h1 class="card-title">{{ $video->title }}</h1>

                <div class="btn-group my-4" role="group">

                    <a class="btn btn-outline-light" href="{{ route('author.show', $video->channel_id) }}" target="_blank">
                        <i class="far fa-user-circle"></i> {{ $video->channel->name ?? $video->channel_id }}
                    </a>

                    <a class="btn btn-outline-light" href="https://www.youtube.com/watch?v={{ $video->id }}" target="_blank">
                        <i class="fab fa-youtube"></i> Посмотреть видео
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container mt-5">
        <video-chart id="{{ $video->id }}" class="my-5 rounded"></video-chart>
        <video-comments id="{{ $video->id }}" class="my-5"></video-comments>
    </div>
@endsection
