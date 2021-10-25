<?php

namespace App\Events;

use App\Models\Comment;
use App\Models\Lesson;
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
     * @var Lesson|null
     */
    private $lesson;

    /**
     * @var Comment|null
     */
    private $comment;

    /**
     * AchievementUnlocked constructor.
     *
     * Could have accepted achievement model object as whole in event,
     * however the the requirement described in Assignment demands achievement name to be accepted
     * As per my opinion, the achievement object would be better option
     *
     * Accepting comment or lesson, to keep a track of  through which comment or lesson, user got the achievement unlocked
     *
     * @param string $achievement_name
     * @param User $user
     * @param Lesson|null $lesson
     * @param Comment|null $comment
     */
    public function __construct(string $achievement_name, User $user, Lesson $lesson = null, Comment $comment = null)
    {
        $this->achievement_name = $achievement_name;
        $this->user = $user;
        $this->lesson = $lesson;
        $this->comment = $comment;
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

    /**
     * @return Lesson|null
     */
    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    /**
     * @return Comment|null
     */
    public function getComment(): ?Comment
    {
        return $this->comment;
    }
}
