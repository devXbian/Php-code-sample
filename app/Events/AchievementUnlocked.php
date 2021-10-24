<?php

namespace App\Events;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class AchievementUnlocked
 *
 * @package App\Events
 */
class AchievementUnlocked
{
    use Dispatchable, SerializesModels;

    /**
     * @var string
     */
    private $achievement_name;

    /**
     * @var User
     */
    private $user;

    /**
     * AchievementUnlocked constructor.
     *
     * @param string $achievement_name
     * @param User $user
     */
    public function __construct(string $achievement_name, User $user)
    {
        $this->achievement_name = $achievement_name;
        $this->user = $user;
    }



    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getAchievementName(): string
    {
        return $this->achievement_name;
    }
}
