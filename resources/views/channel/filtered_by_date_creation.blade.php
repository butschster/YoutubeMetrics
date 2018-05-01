@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <channels-filtered-by-date date="{{ $date }}"></channels-filtered-by-date>
    </div>
@endsection
