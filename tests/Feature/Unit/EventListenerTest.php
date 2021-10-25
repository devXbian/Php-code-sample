<?php

namespace Tests\Feature\Unit;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Listeners\AchievementUnlockedListener;
use App\Listeners\BadgeUnlockedListener;
use App\Listeners\CommentWrittenListener;
use App\Listeners\LessonWatchedListener;
use App\Models\Comment;
use App\Models\Lesson;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class EventListenerTest
 *
 * @package Tests\Feature\Unit
 */
class EventListenerTest extends TestCase
{
    use DatabaseTransactions;


    /**
     * Basic test to verify if events are being listened
     *
     * @return void
     */
    public function test_event_listeners(): void
    {
        Event::fake();

        Event::assertListening(LessonWatched::class, LessonWatchedListener::class);
        Event::assertListening(CommentWritten::class, CommentWrittenListener::class);
        Event::assertListening(AchievementUnlocked::class, AchievementUnlockedListener::class);
        Event::assertListening(BadgeUnlocked::class, BadgeUnlockedListener::class);
    }


    /**
     * Basic test case to unlock beginner badge once user is created
     *
     * @return void
     */
    public function test_beginner_badge(): void
    {
        Event::fake([BadgeUnlocked::class]);

        User::factory()->create();

        Event::assertDispatched(BadgeUnlocked::class);
    }


    /**
     * A basic test example to test if achievement event dispatch
     *
     * @return void
     */
    public function test_lesson_watched(): void
    {
        Event::fake([AchievementUnlocked::class]);

        $user = User::factory()->create();

        $lesson = Lesson::first();

        $user->watched()->syncWithoutDetaching([$lesson->id => ['watched' => true]]);

        //As this is the first lesson watched by user, so achievement unlocked event should get dispatched
        LessonWatched::dispatch($lesson, $user);

        Event::assertDispatched(AchievementUnlocked::class);
        Event::assertNotDispatched(BadgeUnlocked::class);

    }

    /**
     * A basic test example to test if achievement event dispatch
     *
     * @return void
     */
    public function test_comment_written(): void
    {
        Event::fake([AchievementUnlocked::class]);

        $user = User::factory()->create();

        $comment = Comment::query()->create(['body' => Str::random(), 'user_id' => $user->id]);

        //As this will be first comment of newly created user, so achievement unlock event should get dispatch
        CommentWritten::dispatch($comment);

        Event::assertDispatched(AchievementUnlocked::class);
        Event::assertNotDispatched(BadgeUnlocked::class);

    }

    /**
     * A basic test example to test if badge event dispatch
     *
     * @return void
     */
    public function test_badge_unlocked(): void
    {
        Event::fake([BadgeUnlocked::class]);

        $user = User::factory()->create();

        //Once user is created, default he has no achievements unlocked and hence remaining will be all achievements
        $lessons = Lesson::query()->take(5)->get();

        //Watching 5 lesson, which means 2 achievements unlocked
        $lessons->each(static function ($lesson) use ($user) {

            $user->watched()->syncWithoutDetaching([$lesson->id => ['watched' => true]]);

            LessonWatched::dispatch($lesson, $user);
        });

        //Creating 3 comments
        $i = 0;
        while ($i <= 2) {
            //Could have been better approach for comment creation, used this for test cases
            $comment = Comment::query()->create(['body' => Str::random(50), 'user_id' => $user->id]);
            CommentWritten::dispatch($comment);
            $i++;
        }

        Event::assertDispatched(BadgeUnlocked::class);

    }

}
