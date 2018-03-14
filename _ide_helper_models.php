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
 * App\Entities\CommentLike
 *
 * @property string $comment_id
 * @property int $likes
 * @property \Carbon\Carbon|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CommentLike whereCommentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CommentLike whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CommentLike whereLikes($value)
 */
	class CommentLike extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Author
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Author whereUpdatedAt($value)
 */
	class Author extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Comment
 *
 * @property int $id
 * @property string $video_id
 * @property string $author_id
 * @property string|null $text
 * @property int $likes
 * @property \Carbon\Carbon|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Comment whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Comment whereLikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Comment whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Comment whereVideoId($value)
 */
	class Comment extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Bot
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Bot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Bot whereId($value)
 */
	class Bot extends \Eloquent {}
}

namespace App\Entities{
/**
 * App\Entities\Video
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Video whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Video whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Video whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Video whereUpdatedAt($value)
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

