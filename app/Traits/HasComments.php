<?php
namespace Modules\Tools\Traits;

use \App\ModelAbstract as Model;
use Illuminate\Http\Response;
use Modules\Social\Entities\Comment;
use Modules\Tools\Entities\BlackList;
use Modules\User\Entities\User;

/**
 * Trait HasComments
 *
 * @method \Illuminate\Database\Eloquent\Builder commentsOf(User $model = null)
 *
 * @package Modules\Tools\Traits
 */
trait HasComments
{
    /**
     * @return mixed
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Add new Comment to model
     *
     * @param string            $comment
     * @param null|integer|User $user_id
     *
     * @return bool|\Illuminate\Support\Collection|\Model
     */
    public function addComment(string $comment, $user_id = null)
    {
        throw_unless(BlackList::isAllowed($comment), \Exception::class,
            __('tools::black_list.not_allowed_word'), Response::HTTP_FORBIDDEN
        );

        if ( !$user_id && ($user = AuthUser()) ) {
            $user_id = $user->id;
        } else if ( !$user_id ) {
            return false;
        }

        if ( $user_id instanceof User ) {
            $user_id = $user_id->id;
        }

        if ( !$user_id ) return false;

        return $this->comments()->create([
            'comment' => $comment,
            'user_id' => $user_id,
        ]);
    }


    /**
     * Scope to returns comments by user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param User|null                             $model null to use current logged in user
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCommentsOf(\Illuminate\Database\Eloquent\Builder $query, User $model = null)
    {
        $model = is_null($model) ? AuthUser() : $model;

        if ( $this instanceof Model && $this->exists && $this->id ) {
            return $this->comments()->where('user_id', $model->id);
        } else {
            return $query->whereHas('comments', function ($q) use ($model) {
                return $q->where('user_id', $model->id);
            });
        }
    }
}
