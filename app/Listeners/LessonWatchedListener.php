<?php

namespace App\Listeners;


use App\Events\AchievementUnlocked;
use App\Events\LessonWatched;
use App\Models\Achievement;
use Illuminate\Support\Facades\Log;

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
        $lesson = $event->getLesson();

        $user = $event->getUser();

        /**
         * Assuming the Lesson and user shared in payload, Lesson is already attached to user and will exist in watched collection being fetched from user model
         */
        $lessonWatched = $user->watched()->count();

        /**
         * Adding an additional validation, in case the lesson shared with user in payload, is not the one user watched.
         */

        $watched = $user->watched()->where('id', $lesson->id)->first();

        if (null === $watched) {
            Log::error('The Lesson share is not yet watched by user.');
            return false;
        }

        $achievement = Achievement::where('lessons_watched_count', $lessonWatched)->first();

        if ($achievement) {
            AchievementUnlocked::dispatch($achievement->name, $user, $lesson);
        }


    }
}
