@extends('layouts.app')

@section('content')
    <h3 class="py-4 bg-dark text-center text-white mb-5">Проиндексированные видео</h3>

    <div class="container">
        <div class="row">
            @each('video._partials.row', $videos, 'video')
        </div>

        {!! $videos->render() !!}
    </div>
@endsection
