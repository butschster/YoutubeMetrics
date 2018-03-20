<div class="row">
    <div class="col-sm">
        <div class="font-size-30 font-weight-300">{{ format_number($video->views) }}</div>
        <small>{{ __('video.stat.views') }}</small>
    </div>
    <div class="col-sm">
        <div class="font-size-30 font-weight-300">{{ format_number($video->likes) }}</div>
        <small>{{ __('video.stat.likes') }}</small>
    </div>
    <div class="col-sm">
        <div class="font-size-30 font-weight-300">{{ format_number($video->dislikes) }}</div>
        <small>{{ __('video.stat.dislikes') }}</small>
    </div>
    <div class="col-sm">
        <div class="font-size-30 font-weight-300">{{ format_number($video->comments) }}</div>
        <small>{{ __('video.stat.comments') }}</small>
    </div>
    <div class="col-sm">
        <div class="font-size-30 font-weight-300">{{ format_number($spamCommentsCount) }}</div>
        <small>{{ __('video.stat.spam_comments') }}</small>
    </div>
</div>