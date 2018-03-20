<div class="comment mb-3 rounded">

    <a class="float-right text-danger btn btn-sm btn-link" href="https://www.youtube.com/watch?v={{ $comment->video_id }}&lc={{ $comment->id }}" target="_blank">
        <i class="fab fa-youtube fa-lg"></i>
    </a>

    <a class="float-right btn btn-sm btn-link" href="{{ route('comment.show', $comment->id) }}" target="_blank">
        <i class="fas fa-link fa-lg"></i>
    </a>

    <div class="comment-content">
        <span class="badge badge-light">
            <i class="far fa-user-circle"></i>
            <a href="{{ route('channel.show', $comment->channel_id) }}" target="_blank">
                {{ $comment->author->name ?? $comment->channel_id }}
            </a>
        </span>
        <div class="comment-body">
            <p>{{ $comment->text }}</p>
        </div>

        <div class="comment-meta">
            <span class="badge badge-light">
                <i class="far fa-thumbs-up fa-fw fa-lg"></i> {{ $comment->total_likes }}
            </span>
            <span class="badge badge-light">{{ $comment->formatted_date }}</span>
        </div>
    </div>
</div>