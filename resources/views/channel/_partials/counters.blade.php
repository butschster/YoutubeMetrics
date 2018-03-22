<div class="row">
    <div class="col-sm">
        <div class="font-size-30 font-weight-300">{{ format_number($author->views) }}</div>
        <small>{{ __('channel.stat.views') }}</small>
    </div>
    <div class="col-sm">
        <div class="font-size-30 font-weight-300">{{ format_number($author->subscribers) }}</div>
        <small>{{ __('channel.stat.subscribers') }}</small>
    </div>
    <div class="col-sm">
        <div class="font-size-30 font-weight-300">{{ format_number($author->comments) }}</div>
        <small>{{ __('channel.stat.comments') }}</small>
    </div>
</div>