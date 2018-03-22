<div class="row">
    <div class="col-sm">
        <div class="font-size-30 font-weight-300">{{ format_number($channel->views) }}</div>
        <small>{{ __('channel.stat.views') }}</small>
    </div>
    <div class="col-sm">
        <div class="font-size-30 font-weight-300">{{ format_number($channel->subscribers) }}</div>
        <small>{{ __('channel.stat.subscribers') }}</small>
    </div>
    <div class="col-sm">
        <div class="font-size-30 font-weight-300">{{ format_number($channel->comments) }}</div>
        <small>{{ __('channel.stat.comments') }}</small>
    </div>
    <div class="col-sm">
        <div class="font-size-30 font-weight-300">{{ format_number($channel->bot_comments) }}</div>
        <small>{{ __('channel.stat.bot_comments') }}</small>
    </div>
</div>