<?php

namespace App\Listeners;


use App\Events\BadgeUnlocked;
use App\Models\Badge;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
     *a
     * @return false
     * @throws \JsonException
     */
    public function handle(BadgeUnlocked $event)
    {
        $badgeName = $event->getBadgeName();
        $achievement = $event->getAchievement();
        $user = $event->getUser();

        $badge = Badge::where('name', $badgeName)->first();

        if (null === $badge) {
            Log::error('No badge found with given name!!');
            return false;
        }

        try {

            DB::beginTransaction();
            /**
             * keeping current badge reference in users table
             */
            if ($user->current_badge_id) {
                $user->badges()->updateExistingPivot($user->current_badge_id, ['is_current' => false]);
            }
            $user->badges()->syncWithoutDetaching(
                [
                    $badge->id => [
                        'date' => Carbon::now(),   // to keep track of time when this badge was unlocked
                        'achievement_id' => $achievement->id ?? null,
                        'is_current' => true
                    ]
                ]
            );

            $user->current_badge_id = $badge->id;
            $user->save();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug(json_encode(
                [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ], JSON_THROW_ON_ERROR));

            Log::error('Unexpected error, Please contact admin. Original error - ' . $e->getMessage());
            return false;
        }

    }
}
