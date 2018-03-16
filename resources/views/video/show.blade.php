@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <header id="video-header" class="card bg-dark text-white">
            <div class="video-cover" style="background-image: url({{ $video->thumb }});"></div>
            <div class="card-img-overlay d-flex justify-content-center">
                <div class="align-self-center text-center">
                    <h1 class="card-title">{{ $video->title }}</h1>
                    <p class="card-text">{{ $video->channel->title }}</p>
                </div>
            </div>
        </header>

        <video-chart id="{{ $video->id }}" class="mt-5 rounded"></video-chart>
    </div>
@endsection
