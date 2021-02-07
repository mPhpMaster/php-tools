<?php
/**
 * Created by PhpStorm.
 * User: del
 * Date: 1/8/2019
 * Time: 3:53 PM
 */

namespace Modules\Tools\Traits;


use Modules\Tools\Interfaces\Statusable;

/**
 * Trait HasStatus
 *
 * @method static \Illuminate\Database\Eloquent\Builder active() HasStatus::scopeactive()
 * @method static \Illuminate\Database\Eloquent\Builder inActive() HasStatus::scopeinActive()
 * @method static \Illuminate\Database\Eloquent\Builder status($statue = null) HasStatus::scopestatus()
 *
 * @see     HasStatus::scopeactive()
 * @see     HasStatus::scopeinActive()
 * @see     HasStatus::scopestatus()
 *
 * @package Modules\Tools\Traits
 */
trait HasStatus
{

    public function isActive(): bool
    {
        return $this->status == Statusable::STATUS['active'];
    }

    /**
     * @return array
     */
    public static function getAllStatuses(): array
    {
        $statuses = __("tools::static.Statusable_interface");

        if (!is_array($statuses))
            $statuses = [];

        return $statuses;
    }

    /**
     * @param $status
     *
     * @return string
     */
    public static function getStatusKey($status): string
    {
        return (string)self::getAllStatuses()[$status];
    }

    /**
     * @param $status
     *
     * @return string
     */
    public static function getStatus($status): string
    {
        $key = "tools::static.Statusable_interface.{$status}";
        $__ = __($key);

        return (string)$__ == $key ? "$status" : $__;
    }

    /**
     * @return string
     */
    public function statusLabel(): string
    {
        return (string)self::getStatus($this->status);
    }

    /**
     * $this->status_label
     *
     * @param $value
     *
     * @return string
     */
    public function getStatusLabelAttribute($value): string
    {
        return (string)$value ? $value : self::getStatus($this->status);
    }

    /**
     * $this->status_string
     *
     * @param $value
     *
     * @return string
     */
    public function getStatusStringAttribute($value): string
    {
        return (string)$value ? $value : self::getStatus($this->get('status'));
    }

    /**
     * self::activeData()
     * Scope a query to only include active status rows.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActiveData($query)
    {
//        dd(self::getStatusKey('active'));
        return $query->where('status', self::STATUS['active']);
    }

    /**
     * self::approvedData()
     * Scope a query to only include active status rows.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApprovedData($query)
    {
//        dd(self::getStatusKey('active'));
        return $query->where('status', self::STATUS['approved']);
    }

    /**
     * self::approved()
     * Scope a query to only include active status rows.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeapproved($query)
    {
        return $query->withoutGlobalScope('status')
            ->where('status', self::STATUS['approved']);
    }

    /**
     * self::active()
     * Scope a query to only include active status rows.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeactive($query)
    {
        return $query->withoutGlobalScope('status')
            ->where('status', self::STATUS['active']);
    }

    /**
     * self::inActive()
     * Scope a query to only include active status rows.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeinActive($query)
    {
        return $query->withoutGlobalScope('status')
            ->where('status', self::STATUS['inactive']);
    }

    /**
     * self::pending()
     * Scope a query to only include active status rows.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopepending($query)
    {
        return $query->withoutGlobalScope('status')
            ->where('status', self::STATUS['pending']);
    }

    /**
     * self::canceled()
     * Scope a query to only include active status rows.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopecanceled($query)
    {
        return $query->withoutGlobalScope('status')
            ->where('status', self::STATUS['canceled']);
    }

    /**
     * self::used()
     * Scope a query to only include active status rows.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeused($query)
    {
        return $query->withoutGlobalScope('status')
            ->where('status', self::STATUS['used']);
    }

    /**
     * self::banded()
     * Scope a query to only include active status rows.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopebanded($query)
    {
        return $query->withoutGlobalScope('status')
            ->where('status', self::STATUS['banded']);
    }

    /**
     * self::status('active')
     * Scope a query to only include active status rows.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopestatus($query, $status = null)
    {
        $result = $query->withoutGlobalScope('status');
        return (($status = collect($status))->isNotEmpty()) ?
            $result->whereIn('status', $status->toArray()) : $result;
    }

}
