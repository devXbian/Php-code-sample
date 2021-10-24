<?php

namespace App\Listeners;



use App\Events\AchievementUnlocked;

/**
 * Class AchievementUnlockedListener
 *
 * @package App\Listeners
 */
class AchievementUnlockedListener
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Listener handling the achievement unlocked event
     *
     * @param AchievementUnlocked $event
     */
    public function handle(AchievementUnlocked $event)
    {


    }
}
