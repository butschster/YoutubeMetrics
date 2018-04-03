<?php

namespace App\Entities;

use App\Events\Channel\Moderated;
use App\Events\Channel\Reported;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo, HasMany, HasManyThrough
};
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class Channel extends YoutubeModel
{
    use HybridRelations;

    const TYPE_NORMAL = 'normal';
    const TYPE_BOT = 'bot';
    const TYPE_REPORTED = 'reported';
    const TYPE_VERIFIED = 'verified';
    const TYPE_DELETED = 'deleted';

    /**
     * @var array
     */
    protected $casts = [
        'bot' => 'bool',
        'deleted' => 'bool',
        'verified' => 'bool',
        'thumb' => 'string',
        'name' => 'string',
        'total_reports' => 'int',
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
        if ($this->deleted) {
            return static::TYPE_DELETED;
        }

        if ($this->verified) {
            return static::TYPE_VERIFIED;
        }

        if ($this->bot) {
            return static::TYPE_BOT;
        }

        if ($this->total_reports > 0) {
            return static::TYPE_REPORTED;
        }

        return static::TYPE_NORMAL;
    }

    /**
     * @param User $user
     */
    public function sendReport(User $user): void
    {
        if ($this->hasReportFrom($user)) {
            return;
        }

        $this->total_reports += 1;
        $this->save();

        $this->reports()->create([
            'user_id' => $user->id
        ]);

        event(new Reported($this));
    }

    /**
     * @param User $user
     * @return bool
     */
    public function hasReportFrom(User $user): bool
    {
        return $this->reports()->where('user_id', $user->id)->exists();
    }

    /**
     * Пометка канала как спам
     * @param User $user
     */
    public function markAsBot(User $user): void
    {
        $this->update([
            'bot' => true,
            'moderated_by' => $user->getKey()
        ]);

        $this->comments()->update(['is_spam' => true]);
        event(new Moderated($this));
    }

    /**
     * Пометка канала как проверенный
     * @param User $user
     */
    public function markAsVerified(User $user): void
    {
        $this->update([
            'verified' => true,
            'bot' => false,
            'total_reports' => 0,
            'moderated_by' => $user->getKey()
        ]);

        $this->reports()->delete();
        $this->comments()->update(['is_spam' => false]);
        event(new Moderated($this));
    }

    /**
     * Пометка канала как нормального
     *
     * при этом у него остаюстя репорты, которые можно убрать при верификации
     * @param User $user
     */
    public function markAsNormal(User $user): void
    {
        $this->update([
            'bot' => false,
            'moderated_by' => $user->getKey()
        ]);

        $this->comments()->update(['is_spam' => false]);
        event(new Moderated($this));
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
    public function scopeFilterVerified(Builder $builder)
    {
        return $builder->where('verified', false);
    }

    /**
     * @param Builder $builder
     * @return $this
     */
    public function scopeOnlyReported(Builder $builder)
    {
        return $builder->where('bot', false)->where('total_reports', '>', 0);
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
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

    /**
     * @return HasMany
     */
    public function reports(): HasMany
    {
        return $this->hasMany(ChannelReport::class);
    }

    /**
     * Пользователь, который модерировал канал
     *
     * @return BelongsTo
     */
    public function moderatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }
}
