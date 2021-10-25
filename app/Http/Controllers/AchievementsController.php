<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;

/**
 * Class AchievementsController
 *
 * @package App\Http\Controllers
 */
class AchievementsController extends Controller
{
    /**
     * Method to share the achievements details of user
     *
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(User $user)
    {
        $currentBadge = $user->currentBadge;

        $nextBadge = ($currentBadge !== null) ? ($currentBadge->nextBadge) : Badge::where('prev_badge_id', null)->first();

        $achievements = $user->achievements;

        $masterAchievements = Achievement::all();

        $remainingAchievement[] = $masterAchievements->where('comments_written_count', null)->sortBy('lessons_watched_count')->diff($achievements->where('comments_written_count', null))->first()->name ?? null;
        $remainingAchievement[] = $masterAchievements->where('lessons_watched_count', null)->sortBy('comments_written_count')->diff($achievements->where('lessons_watched_count', null))->first()->name ?? null;


        return response()->json([
            'unlocked_achievements' => $achievements->pluck('name')->toArray(),
            'next_available_achievements' => array_values(array_filter($remainingAchievement)),
            'current_badge' => $currentBadge->name ?? null,
            'next_badge' => $nextBadge->name ?? null,
            'remaining_to_unlock_next_badge' => $nextBadge ? (int)$nextBadge->achievements_unlocked_count - (int)($achievements->count()) : null,
        ]);
    }
}
