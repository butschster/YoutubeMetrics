<div class="{{ $colSize }}">
    <div class="card mb-4 box-shadow">
        <a href="{{ route('video.show', $video) }}">
            <img class="card-img-top" src="{{ $video->thumb }}">
        </a>
        <div class="card-body">
            <a class="card-subtitle mb-2" href="{{ route('video.show', $video) }}">{{ $video->title }}</a>
        </div>
        <div class="card-footer bg-white">
            <div class="small d-flex justify-content-between align-self-end">
                <a href="{{ route('channel.show', $video->channel_id) }}">
                    <img src="{{ $video->channel->thumb }}" class="rounded-circle mr-2" width="25px"> {{ $video->channel->name }}
                </a>
                <span class="text-muted">{{ $video->diff_date }}</span>
            </div>
        </div>
    </div>
</div>