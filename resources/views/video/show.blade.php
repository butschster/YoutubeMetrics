@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="bg-white box-shadow p-4 mt-5 ">
            <h3 class="card-title mb-3">{{ $video->title }}</h3>

            <a href="{{ route('channel.show', $video->channel_id) }}" target="_blank">
                <img src="{{ $video->channel->thumb }}" class="rounded-circle mr-2" width="30px"> {{ $video->channel->name }}
            </a>
        </div>

        <div class="bg-dark py-3 text-center text-white">
            @include('video._partials.counters')
        </div>
        <video-chart id="{{ $video->id }}"></video-chart>
        <iframe class="video-player" width="100%"
                src="https://www.youtube.com/embed/{{ $video->id }}?rel=0&amp;showinfo=0"
                frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>


        <div class="p-3 bg-white text-center mb-3">
            <div class="">
                @if($tags->count() > 0)
                    <div>
                        @foreach($tags as $tag => $link)
                            <a href="{{ $link }}" class="badge badge-light">{{ $tag }}</a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="text-center">
            <a class="btn bg-danger text-white" href="https://www.youtube.com/watch?v={{ $video->id }}"
               target="_blank">
                <i class="fab fa-youtube"></i> Посмотреть на youtube
            </a>
        </div>

        <video-comments id="{{ $video->id }}" class="my-5"></video-comments>
    </div>
@endsection
