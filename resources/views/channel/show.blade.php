@extends('layouts.app')

@section('content')

    <div class="container mt-5">
        <header id="channel-header" class="card rounded-0 text-white channel-type-{{ $channel->type }}">
            @if($channel->thumb)
                <div class="cover" style="background-image: url({{ $channel->thumb }});"></div>
            @else
                <div class="cover bg-dark"></div>
            @endif

            <div class="card-img-overlay d-flex justify-content-center">
                <div class="align-self-center text-center">
                    <h1 class="card-title">{{ $channel->name }}</h1>
                    <h3>{{ trans('channel.type.'.$channel->type) }}</h3>

                    <div>
                        <span class="badge badge-light">ID: <strong>{{ $channel->id }}</strong></span>
                    </div>

                    <div class="btn-group my-4" role="group">

                        <a class="btn btn-outline-light" href={{ $channel->youtube_link }}" target="_blank">
                            <i class="fab fa-youtube fa-fw fa-lg"></i> Канал
                        </a>

                        <a class="btn btn-outline-light" href="{{ $channel->top_comments_link }}" target="_blank">
                            <i class="fab fa-lg fa-fw fa-searchengin"></i> Поиск комментариев
                        </a>

                        @can('report', $channel)
                            <button-report id="{{ $channel->id }}"></button-report>
                        @endcan
                    </div>
                </div>
            </div>
        </header>

        <div class="bg-primary py-3 text-center text-white">
            @include('channel._partials.counters')
        </div>

        <channel-chart id="{{ $channel->id }}"></channel-chart>

        @if($videos->count() > 0)
            <div class="row mt-5">
                @foreach($videos as $video)
                    @include('video._partials.row', ['video' => $video, 'colSize' => 'col-md-4'])
                @endforeach
            </div>

            {!! $videos->render() !!}
        @endif

        <channel-comments id="{{ $channel->id }}" class="my-5"></channel-comments>
    </div>
@endsection