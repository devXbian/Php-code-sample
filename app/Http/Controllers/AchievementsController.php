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

        $nextBadge = ($currentBadge!==null) ? ($currentBadge->nextBadge) : Badge::where('prev_badge_id', null)->first();

        $achievements = $user->achievements;

        $masterAchievements = Achievement::all();

        $remainingAchievements = $masterAchievements->diff($achievements);

        return response()->json([
            'unlocked_achievements' => $achievements->pluck('name')->toArray(),
            'next_available_achievements' => $remainingAchievements->pluck('name')->toArray(),
            'current_badge' => $currentBadge->name ?? null,
            'next_badge' => $nextBadge->name ?? null,
            'remaining_to_unlock_next_badge' => $nextBadge ? (int)$nextBadge->achievements_unlocked_count - (int)($achievements->count()) : null,
        ]);
    }
}
