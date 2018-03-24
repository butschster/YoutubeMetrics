@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="bg-white box-shadow p-4 mt-5">
            <a href="{{ route('channel.show', $video->channel_id) }}" target="_blank">
                <img src="{{ $video->channel->thumb }}" class="rounded-circle mr-2" width="30px"> {{ $video->channel->name }}
            </a>
            <h3 class="card-title mt-3 mb-0">{{ $video->title }}</h3>
            <p class="small">{{ str_limit($video->description, 500) }}</p>
        </div>

        <div class="bg-dark py-3 text-center text-white">
            @include('video._partials.counters')
        </div>
        <video-chart id="{{ $video->id }}"></video-chart>

        @include('video._partials.player')

        <div class="p-3 bg-white text-center mb-3">
            @include('video._partials.tags')
        </div>

        <div class="text-center">
            <a class="btn bg-danger text-white" href="https://www.youtube.com/watch?v={{ $video->id }}"
               target="_blank">
                <i class="fab fa-youtube"></i> Посмотреть на youtube
            </a>

            @can('clear_comments_cache', $video)
            <video-clear-cache-button id="{{ $video->id }}" class="btn-outline-danger"></video-clear-cache-button>
            @endcan
        </div>

        <video-comments id="{{ $video->id }}" class="my-5"></video-comments>
    </div>
@endsection
