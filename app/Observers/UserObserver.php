<?php

namespace App\Observers;

use App\Events\BadgeUnlocked;
use App\Models\Badge;
use App\Models\User;

/**
 * Class UserObserver
 *
 * @package App\Observers
 */
class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param User $user
     *
     * @return void
     */
    public function created(User $user)
    {
        //Once user is created he/she should get badge unlocked, if there is any with 0 achievements
        $badge = Badge::where('prev_badge_id', null)->where('achievements_unlocked_count', 0)->first();

        if ($badge) {
            BadgeUnlocked::dispatch($badge->name, $user);
        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @param User $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param User $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param User $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param User $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
