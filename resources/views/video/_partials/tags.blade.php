@if($tags->count() > 0)
    <div>
        @foreach($tags as $tag => $link)
            <a href="{{ $link }}" class="badge badge-light text-primary font-weight-100">#{{ $tag }}</a>
        @endforeach
    </div>
@endif