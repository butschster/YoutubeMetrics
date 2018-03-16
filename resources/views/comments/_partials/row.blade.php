<div class="comment mb-3 rounded">
    <div class="comment-content">
        <h6 class="small comment-meta">
            <span class="badge badge-light">
                <i class="far fa-thumbs-up"></i> {{ $comment->total_likes }}
            </span>

            <span class="text-muted">
                Автор: <a href="{{ route('author.show', $comment->author_id) }}" target="_blank">{{ $comment->author_id }}</a>
            </span>
        </h6>
        <div class="comment-body">
            <p>{{ $comment->text }}</p>
            <span class="badge badge-info">{{ $comment->created_at->format('d.m.Y H:i:s') }}</span>
        </div>
    </div>
</div>