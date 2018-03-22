@extends('layouts.app')

@section('content')
    <div class="container mt-5">

        <div class="row">
            @foreach($videos as $video)
                @include('video._partials.row', ['video' => $video, 'colSize' => 'col-md-4'])
            @endforeach
        </div>

        {!! $videos->render() !!}

        <channels-followed class="mt-5"></channels-followed>
    </div>
@endsection
