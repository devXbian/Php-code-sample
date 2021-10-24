<?php

namespace App\Listeners;


use App\Events\LessonWatched;

/**
 * Class LessonWatchedListener
 *
 * @package App\Listeners
 */
class LessonWatchedListener
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
     * Listener handling the lesson watched event
     *
     * @param LessonWatched $event
     */
    public function handle(LessonWatched $event)
    {


    }
}
