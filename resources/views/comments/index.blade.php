@extends('layouts.app')

@section('content')
    <h3 class="py-4 bg-dark text-center text-white mb-5">Комментарии ботов за последние 24 часа</h3>

    <div class="container">
        <div class="comments">
            <h3 class="mb-4">Комментарии ({{ $comments->count() }})</h3>

            @foreach($comments as $comment)
                @include('comments._partials.row', ['comment' => $comment])
            @endforeach
        </div>

        {!! $comments->render() !!}
    </div>
@endsection
