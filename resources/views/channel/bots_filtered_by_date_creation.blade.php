@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <bots-filtered-by-date date="{{ $date }}"></bots-filtered-by-date>
    </div>
@endsection
