<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Entities{
/**
 * App\Entities\Tag
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Video[] $videos
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Tag whereUpdatedAt($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Author
 *
 * @property string $id
 * @property int $total_comments
 * @property int $bot
 * @property int $deleted
 * @property string|null $registered_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $reports
 * @property string|null $thumb
 * @property string|null $country
 * @property string $name
 * @property int $views
 * @property \Illuminate\Database\Eloquent\Collection|\App\Entities\Comment[] $comments
 * @property int $subscribers
 * @property-read string $link
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\ChannelStat[] $statistics
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Video[] $videos
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author live()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author onlyBots()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author onlyReported()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author whereBot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author whereDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author whereRegisteredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author whereReports($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author whereSubscribers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author whereTotalComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author whereViews($value)
 */
	class Author extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Comment
 *
 * @property string $id
 * @property string $video_id
 * @property string $channel_id
 * @property string|null $text
 * @property int $total_likes
 * @property int $is_spam
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Entities\Author $author
 * @property-read string $formatted_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\CommentLike[] $likes
 * @property-read \App\Entities\Video $video
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Comment filterByChannel($author)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Comment filterByVideo($video)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Comment onlySpam()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Comment whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Comment whereIsSpam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Comment whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Comment whereTotalLikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Comment whereVideoId($value)
 */
	class Comment extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Channel
 *
 * @property string $id
 * @property string $title
 * @property \Carbon\Carbon|null $created_at
 * @property string|null $deleted_at
 * @property bool $follow
 * @property-read \App\Entities\Author $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Video[] $videos
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Channel onlyFollow()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Channel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Channel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Channel whereFollow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Channel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Channel whereTitle($value)
 */
	class Channel extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Bot
 *
 * @property string $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $deleted
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Comment[] $comments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Bot live()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Bot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Bot whereDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Bot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Bot whereUpdatedAt($value)
 */
	class Bot extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Video
 *
 * @property string $id
 * @property string $title
 * @property string|null $description
 * @property int $views
 * @property int $likes
 * @property int $dislikes
 * @property \Illuminate\Database\Eloquent\Collection|\App\Entities\Comment[] $comments
 * @property int $favorites
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $channel_id
 * @property string|null $thumb
 * @property-read \App\Entities\Author $channel
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\VideoStat[] $statistics
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Tag[] $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Video whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Video whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Video whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Video whereDislikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Video whereFavorites($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Video whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Video whereLikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Video whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Video whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Video whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Video whereViews($value)
 */
	class Video extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

