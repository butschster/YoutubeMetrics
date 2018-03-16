<div class="{{ $colSize }}">
    <div class="card mb-4 box-shadow">
        <a href="{{ route('video.show', $video) }}">
            <img class="card-img-top" src="{{ $video->thumb }}">
        </a>
        <div class="card-body">
            <a class="card-subtitle mb-2" href="{{ route('video.show', $video) }}">{{ $video->title }}</a>

            <div class="mt-3 small text-muted">
                Канал: <a href="{{ route('author.show', $video->channel) }}">{{ $video->channel->title }}</a>
            </div>
            <div class="text-right">
                <small class="text-muted">{{ $video->created_at->diffForHumans() }}</small>
            </div>
        </div>
    </div>
</div>