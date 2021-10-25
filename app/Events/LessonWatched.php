<?php

namespace App\Events;

use App\Models\User;
use App\Models\Lesson;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class LessonWatched
 *
 * @package App\Events
 */
class LessonWatched
{
    use Dispatchable, SerializesModels;

    /**
     * @var Lesson
     */
    private $lesson;

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new event instance.
     *
     * @param Lesson $lesson
     * @param User $user
     */
    public function __construct(Lesson $lesson, User $user)
    {
        $this->lesson = $lesson;
        $this->user = $user;
    }

    /**
     * @return Lesson
     */
    public function getLesson(): Lesson
    {
        return $this->lesson;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
