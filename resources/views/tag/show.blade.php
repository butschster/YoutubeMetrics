@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="card-title my-5"><small class="text-muted">Поиск по тегу</small> {{ $tag->name }}</h1>

        <div class="row">
            @foreach($videos as $video)
                @include('video._partials.row', ['video' => $video, 'colSize' => 'col-md-4'])
            @endforeach
        </div>

        {!! $videos->render() !!}
    </div>
@endsection
