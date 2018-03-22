<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Channel extends Model
{

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @param null|string $name
     * @return string
     */
    public function getNameAttribute($name): ?string
    {
        return $name ?? $this->id;
    }

    /**
     * @return string
     */
    public function getLinkAttribute()
    {
        return route('channel.show', $this->id);
    }

    /**
     * Ссылка на канал на Youtube
     *
     * @return string
     */
    public function getYoutubeLinkAttribute(): string
    {
        return "https://www.youtube.com/channel/{$this->id}";
    }

    /**
     * Ссылка на сервис поиска комментариев по каналу
     *
     * @return string
     */
    public function getTopCommentsLinkAttribute(): string
    {
        return "https://www.t30p.ru/search.aspx?s={$this->id}";
    }

    /**
     * @return string
     */
    public function type(): string
    {
        if ($this->bot) {
            return 'bot';
        }

        if ($this->reports > 0) {
            return 'reported';
        }

        return 'normal';
    }

    public function sendReport()
    {
        return $this->updateReports(1);
    }

    /**
     * @param int $score
     */
    public function updateReports(int $score)
    {
        if (is_null($this->reports)) {
            $this->reports = 0;
        }

        if ($score > 0) {
            $this->reports += $score;
        } else if ($this->reports > ($score * -1)) {
            $this->reports -= ($score * -1);
        }

        $this->save();
    }

    public function markAsBot(): void
    {
        $this->bot = true;
        $this->save();

        $this->comments()->update(['is_spam' => true]);
    }

    /**
     * @param Builder $builder
     * @return $this
     */
    public function scopeLive(Builder $builder)
    {
        return $builder->where('deleted', false);
    }

    /**
     * @param Builder $builder
     * @return $this
     */
    public function scopeOnlyBots(Builder $builder)
    {
        return $builder->where('bot', true);
    }

    /**
     * @param Builder $builder
     * @return $this
     */
    public function scopeOnlyReported(Builder $builder)
    {
        return $builder->where('bot', false)->where('reports', '>', 0);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statistics()
    {
        return $this->hasMany(ChannelStat::class);
    }
}
