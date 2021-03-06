@extends('layouts.app')

@section('content')
    <header id="comment-header" class="card bg-dark text-white rounded-0">
        <div class="d-flex justify-content-center">
            <div class="align-self-center text-center">
                <div class="btn-group my-4" role="group">
                    <a class="btn btn-outline-light" href="{{ route('channel.show', $comment->channel_id) }}" target="_blank">
                        <i class="far fa-user-circle"></i> {{ $channel->name ?? $comment->channel_id }}
                    </a>

                    <a class="btn btn-outline-light" href="{{ $comment->youtube_link }}" target="_blank">
                        <i class="fab fa-youtube fa-lg"></i> Посмотреть на youtube
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container mt-5">

        <div class="card p-3">
            <blockquote class="blockquote mb-0 card-body">
                <p>{{ $comment->text }}</p>
                <footer class="blockquote-footer">
                    <small class="text-muted">
                        Написал {{ $comment->formatted_date }} <cite>{{ $author->name ?? $comment->channel_id }}</cite>
                    </small>
                </footer>
            </blockquote>
        </div>

        <comment-chart id="{{ $comment->id }}" class="mt-5 rounded"></comment-chart>
    </div>
@endsection
