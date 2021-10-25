<?php

namespace App\Events;

use App\Models\Achievement;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class BadgeUnlocked
 *
 * @package App\Events
 */
class BadgeUnlocked
{
    use Dispatchable, SerializesModels;

    /**
     * @var string
     */
    private $badge_name;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Achievement|null
     */
    private $achievement;

    /**
     * BadgeUnlocked constructor.
     *
     * Could have accepted badge model object as whole in event,
     * however the the requirement described in Assignment demands badge name to be accepted.
     * As per my opinion badge object in payload, would be better approach
     *
     * Accepting achievement, to keep a track of through which achievement, user got the badge unlocked
     *
     * @param string $badge_name
     * @param User $user
     * @param Achievement|null $achievement
     */
    public function __construct(string $badge_name, User $user, Achievement $achievement = null)
    {
        $this->badge_name = $badge_name;
        $this->user = $user;
        $this->achievement = $achievement;
    }

    /**
     * @return string
     */
    public function getBadgeName(): string
    {
        return $this->badge_name;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Achievement|null
     */
    public function getAchievement(): ?Achievement
    {
        return $this->achievement;
    }
}
