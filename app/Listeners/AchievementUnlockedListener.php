<?php

namespace App\Listeners;


use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\Achievement;
use App\Models\Badge;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
     *
     * @return bool
     */
    public function handle(AchievementUnlocked $event)
    {
        $user = $event->getUser();
        $achievementName = $event->getAchievementName();
        $lesson = $event->getLesson();
        $comment = $event->getComment();

        $achievement = Achievement::where('name', $achievementName)->first();

        if (null === $achievement) {
            Log::error('No achievement found with given name!!');
            return false;
        }

        $user->achievements()->syncWithoutDetaching(
            [
                $achievement->id => [
                    'date' => Carbon::now(),   // to keep track of time when this achievement was unlocked
                    'lesson_id' => $lesson->id ?? null,
                    'comment_id' => $comment->id ?? null,
                ]
            ]
        );

        $achievementsCount = $user->achievements->count();

        $badge = Badge::where('achievements_unlocked_count', $achievementsCount)->first();

        if ($badge) {
            BadgeUnlocked::dispatch($badge->name, $user, $achievement);
        }

        return true;
    }
}
