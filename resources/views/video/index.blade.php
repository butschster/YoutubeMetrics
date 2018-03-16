@extends('layouts.app')

@section('content')
    <h3 class="py-4 bg-dark text-center text-white mb-5">Проиндексированные видео</h3>

    <div class="container">
        <div class="row">
            @foreach($videos as $video)
                @include('video._partials.row', ['video' => $video, 'colSize' => 'col-md-4'])
            @endforeach
        </div>

        {!! $videos->render() !!}
    </div>
@endsection
