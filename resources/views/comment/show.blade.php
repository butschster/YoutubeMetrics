@extends('layouts.app')

@section('content')
    <header id="comment-header" class="card bg-dark text-white rounded-0">
        <div class="d-flex justify-content-center">
            <div class="align-self-center text-center">
                <div class="btn-group my-4" role="group">
                    <a class="btn btn-outline-light" href="{{ route('author.show', $comment->channel_id) }}" target="_blank">
                        <i class="far fa-user-circle"></i> {{ $author->name ?? $comment->channel_id }}
                    </a>

                    <a class="btn btn-outline-light" href="https://www.youtube.com/watch?v={{ $comment->video_id }}&lc={{ $comment->id }}" target="_blank">
                        <i class="fab fa-youtube fa-lg"></i> Посмотреть на youtube
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container mt-5">
        <blockquote class="blockquote">
            <p class="mb-0">{{ $comment->text }}</p>
            <footer class="blockquote-footer">Написал {{ $comment->formatted_date }} {{ $author->name ?? $comment->channel_id }}</footer>
        </blockquote>



        <comment-chart id="{{ $comment->id }}" class="mt-5 rounded"></comment-chart>
    </div>
@endsection
