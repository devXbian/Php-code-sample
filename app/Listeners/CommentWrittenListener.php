<?php

namespace App\Listeners;


use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Models\Achievement;

/**
 * Class CommentWrittenListener
 *
 * @package App\Listeners
 */
class CommentWrittenListener
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
     * Listener handling the comment written event
     *
     * @param CommentWritten $event
     */
    public function handle(CommentWritten $event)
    {
        $comment = $event->getComment();

        $user = $comment->user;

        $commentsWritten = $user->comments->count();

        $achievement = Achievement::where('comments_written_count', $commentsWritten)->first();

        if ($achievement) {
            AchievementUnlocked::dispatch($achievement->name, $user, null, $comment);
        }

        return true;
    }
}
