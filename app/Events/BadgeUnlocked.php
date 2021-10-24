<?php

namespace App\Events;

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
     * BadgeUnlocked constructor.
     *
     * @param string $badge_name
     * @param User $user
     */
    public function __construct(string $badge_name, User $user)
    {
        $this->badge_name = $badge_name;
        $this->user = $user;
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
}
