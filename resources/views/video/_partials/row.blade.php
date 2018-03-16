<div class="col-md-4">
    <div class="card mb-4 box-shadow">
        <a href="{{ route('video.show', $video) }}">
            <img class="card-img-top" src="{{ $video->thumb }}">
        </a>
        <div class="card-body">
            <h6 class="card-title text-muted">
                {{ $video->channel->title }}
            </h6>
            <a class="card-subtitle mb-2" href="{{ route('video.show', $video) }}">{{ $video->title }}</a>

            <div class="text-right">
                <small class="text-muted">{{ $video->created_at->diffForHumans() }}</small>
            </div>
        </div>
    </div>
</div>