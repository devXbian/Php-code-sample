<?php

namespace App\Listeners;


use App\Events\CommentWritten;

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


    }
}
