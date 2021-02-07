<?php
/**
 * Created by PhpStorm.
 * User: del
 * Date: 1/8/2019
 * Time: 3:53 PM
 */

namespace Modules\Tools\Traits;

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
trait HasNotifications
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * Alias: $this->notifications
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifis()
    {
        return $this->notifications();
    }

    /**
     * Alias: $this->readNotifications
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function readeds()
    {
        return $this->readNotifications();
    }

    /**
     * Alias: unreadNotifications
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function unreadeds()
    {
        return $this->unreadNotifications();
    }

    /**
     * Alias: $this->read()
     *
     * @return bool
     */
    public function isReaded()
    {
        return $this->read_at !== null;
    }

    /**
     * Alias: $this->unread()
     *
     * @return bool
     */
    public function isUnreaded()
    {
        return $this->read_at === null;
    }


}
