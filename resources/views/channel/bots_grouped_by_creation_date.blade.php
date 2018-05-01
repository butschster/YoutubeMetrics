@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        @foreach($groupedBots as $date => $bots)
            @php
                $percents = round(($bots->count() * 100) / $max);
                if($percents < 1) $percents = 1;
                $dateFormatted = \Carbon\Carbon::createFromFormat('d.m.Y', $date)->toDateString();
            @endphp

            <div class="card mb-3 rounded-0">
                <div class="card-body">
                    <h5 class="card-title">{{ $date }}</h5>
                    <a
                            href="{{ route('channel.created.date', $dateFormatted) }}"
                            class="btn btn-sm btn-outline-primary"
                            target="_blank"
                    >
                        <i class="fas fa-search"></i> Поиск ботов
                    </a>
                    <a
                            href="{{ route('channel.bots.date', $dateFormatted) }}"
                            class="btn btn-sm btn-outline-primary"
                            target="_blank"
                    >
                        <i class="fas fa-search"></i> Список ботов
                    </a>
                </div>

                <div class="progress rounded-0">
                    <div class="progress-bar" role="progressbar"
                         style="width: {{ $percents * 2 }}%"
                         aria-valuenow="25"
                         aria-valuemin="0"
                         aria-valuemax="100">{{ $bots->count() }}</div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
