<?php

namespace App\Listeners;


use App\Events\BadgeUnlocked;

/**
 * Class BadgeUnlockedListener
 *
 * @package App\Listeners
 */
class BadgeUnlockedListener
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
     * Listener handling the Badge unlocked event
     *
     * @param BadgeUnlocked $event
     */
    public function handle(BadgeUnlocked $event)
    {


    }
}
