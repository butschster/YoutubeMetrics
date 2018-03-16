@extends('layouts.app')

@section('content')
    <header id="author-header" class="text-center text-white author-type-{{ $author->type() }}">
        <h1 class="pt-5">{{ $author->id }}</h1>
        <h3>{{ trans('author.type.'.$author->type()) }}</h3>

        <div class="btn-group my-4" role="group">
            <a class="btn btn-outline-light" href="https://www.t30p.ru/search.aspx?s={{ $author->id }}" target="_blank">
                <i class="fab fa-lg fa-fw fa-searchengin"></i> Поиск комментариев
            </a>
        </div>
    </header>

    <div class="container mt-5">
        <author-comments id="{{ $author->id }}" class="my-5"></author-comments>
    </div>
@endsection