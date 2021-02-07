<?php
/**
 * Created by PhpStorm.
 * User: del
 * Date: 1/8/2019
 * Time: 3:53 PM
 */

namespace Modules\Tools\Traits;


use \App\ModelAbstract as Model;
use Modules\Social\Entities\Rate;
use Modules\User\Entities\User;

/**
 * Trait HasRates
 *
 * @method \Illuminate\Database\Eloquent\Builder ratesOf(User $model = null)
 *
 * @package Modules\Tools\Traits
 */
trait HasRates
{
    /**
     * View for show rating stars.
     *
     * @var string
     */
    public static $rating_view_name = 'home::template.partials.rate_star';

    public function rates()
    {
        return $this->morphMany(Rate::class, 'rateable');
    }

    public function avgRate()
    {
        return $this->rates ? round($this->rates->avg('rate'), 2) : 0;
    }

    /**
     * Add new Rate to model
     *
     * @param int               $rate
     * @param null|integer|User $user_id
     *
     * @return bool
     */
    public function addRate(int $rate, $user_id = null)
    {
        if (!$user_id && ($user = AuthUser())) {
            $user_id = $user->id;
        } else if (!$user_id) {
            return false;
        }

        if ($user_id instanceof User) {
            $user_id = $user_id->id;
        }

        if (!$user_id) return false;

        // dE(
        //     [
        //         'rate' => $rate,
        //         'user_id' => $user_id,
        //     ],$this
        // );
        $this->rates()->create([
            'rate' => $rate,
            'user_id' => $user_id,
        ]);

        return true;
    }

    /**
     * returns if $this user can rate the given service.
     *
     * @param User|null $model
     *
     * @return bool
     */
    public function canRate(User $model = null)
    {
        $model = $model ?: AuthUser();
        return $this->ratesOf($model)->count() === 0;
    }

    /**
     * Scope to returns rates by user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param User|null $model null to use current logged in user
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRatesOf(\Illuminate\Database\Eloquent\Builder $query, User $model = null)
    {
        $model = is_null($model) ? AuthUser() : $model;

        if($this instanceof Model && $this->exists && $this->id) {
            return $this->rates()->where('user_id', $model->id);
        } else {
            return $query->whereHas('rates', function ($q) use($model) {
                return $q->where('user_id', $model->id);
            });
        }
    }

    /**
     * Return rendered (html) rate stars view.
     *
     * @param array $data
     *
     * @return string
     * @throws \Throwable
     */
    public function renderRatingView(array $data = [])
    {
        $data['value'] = $data['value'] ?? ($this->rates ? $this->rates->avg('rate') : 0);

        return view(static::$rating_view_name, $data)->render();
    }

    /**
     * Get the string contents of rating star view for this product
     *
     * @param array $data
     *
     * @return string|null
     * @throws \Throwable
     */
    public function getRatingStarsView($data = []): ?string
    {
        return when(static::canShowRatingStarsView(), returnClosure($this->renderRatingView($data)), returnTrue());
    }

    /**
     * Returns if rating star view is allowed to show.
     *
     * @return bool
     */
    abstract public static function canShowRatingStarsView(): bool;
}
