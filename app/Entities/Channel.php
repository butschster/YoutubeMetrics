<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\{
    HasMany, HasManyThrough
};
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class Channel extends YoutubeModel
{
    use HybridRelations;

    const TYPE_NORMAL = 'normal';
    const TYPE_BOT = 'bot';
    const TYPE_REPORTED = 'reported';

    /**
     * @var array
     */
    protected $casts = [
        'bot' => 'bool',
        'deleted' => 'bool',
        'thumb' => 'string',
        'name' => 'string',
        'reports' => 'int',
        'views' => 'int',
        'comments' => 'int',
        'subscribers' => 'int',
        'total_comments' => 'int',
        'bot_comments' => 'int'
    ];

    /**
     * Получение имени канала. Если имя не указано, то будет взят ID канала
     *
     * @param null|string $name
     * @return string
     */
    public function getNameAttribute($name): ?string
    {
        return $name ?? $this->id;
    }

    /**
     * Получение ссылки на канал
     *
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
     * Получение типа канала
     *
     * @return string
     */
    public function getTypeAttribute(): string
    {
        if ($this->bot) {
            return static::TYPE_BOT;
        }

        if ($this->reports > 0) {
            return static::TYPE_REPORTED;
        }

        return static::TYPE_NORMAL;
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
        } else {
            $this->reports = 0;
        }

        $this->save();
    }

    /**
     * Пометка канала как спам
     */
    public function markAsBot(): void
    {
        $this->bot = true;
        $this->save();

        $this->comments()->update(['is_spam' => true]);
    }

    /**
     * Пометка канала как нормального
     */
    public function markAsNormal(): void
    {
        $this->reports = 0;
        $this->bot = false;
        $this->save();

        $this->comments()->update(['is_spam' => false]);
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
    public function scopeFilterBots(Builder $builder)
    {
        return $builder->where('bot', false);
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
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return HasManyThrough
     */
    public function videoComments(): HasManyThrough
    {
        return $this->hasManyThrough(Comment::class, Video::class);
    }

    /**
     * @return HasMany
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    /**
     * @return HasMany
     */
    public function statistics(): HasMany
    {
        return $this->hasMany(ChannelStat::class);
    }
}
