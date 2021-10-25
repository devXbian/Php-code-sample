<?php

namespace App\Providers;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use App\Listeners\AchievementUnlockedListener;
use App\Listeners\BadgeUnlockedListener;
use App\Listeners\CommentWrittenListener;
use App\Listeners\LessonWatchedListener;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CommentWritten::class => [
            CommentWrittenListener::class
        ],
        LessonWatched::class => [
            LessonWatchedListener::class
        ],
        AchievementUnlocked::class => [
            AchievementUnlockedListener::class
        ],
        BadgeUnlocked::class => [
            BadgeUnlockedListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Added user observer to observe the user event, specially here to observe the new created user
         */
        User::observe(UserObserver::class);
    }
}
