<?php

namespace Tests\Feature;

use App\Dictionaries\Badges;
use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Models\Achievement;
use App\Models\Comment;
use App\Models\Lesson;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class AchievementTest
 *
 * @package Tests\Feature
 */
class AchievementTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example(): void
    {
        $user = User::factory()->create();

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200);
    }

    /**
     * A basic test example if invalid user id is passed.
     *
     * @return void
     * @throws \Exception
     */
    public function test_no_user(): void
    {
        $user = User::query()->latest()->first();

        $id = ($user->id ?? 0) + random_int(1, 20);

        $response = $this->get("/users/{$id}/achievements");

        $response->assertNotFound();
    }

    /**
     * A basic test example of current badge.
     *
     * @return void
     * @throws \Exception
     */
    public function test_badges(): void
    {
        $user = User::factory()->create();

        // Once user is created default badge is one which has no previous badges and 0 achievements
        // $badge = Badge::where('prev_badge_id', null)->where('achievements_unlocked_count', 0)->first();  // This will be Beginner

        // $nextBadge = $badge->nextBadge ?? null;  // This will be Intermediate

        $response = $this->get("/users/{$user->id}/achievements");

        // fetching count of achievements from config
        $count = config('settings.badges_info.' . Badges::INTERMEDIATE . '.achievement_count') - config('settings.badges_info.' . Badges::BEGINNER . '.achievement_count');

        $response->assertJsonPath('current_badge', Badges::BEGINNER);
        $response->assertJsonPath('next_badge', Badges::INTERMEDIATE);
        $response->assertJsonPath('remaining_to_unlock_next_badge', $count);
    }

    /**
     * A basic test example of next badge if current badge is null (Not possible in given assignment case).
     * Adding this test to make it full proof, so that in case if such case arises
     *
     * @return void
     * @throws \Exception
     */
    public function test_next_badge_if_no_current(): void
    {
        $user = User::factory()->create();

        //Once user is created default badge is one which has no previous badges and 0 achievements
        // Making user current badge as null

        $user->badges()->detach([$user->current_badge_id]);
        $user->current_badge_id = null;
        $user->save();

        //Now by default if no current badge is there, first badge available should eb considered as next badge
        //  $badge = Badge::where('prev_badge_id', null)->first();   This should be Beginner

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertJsonPath('next_badge', Badges::BEGINNER);
    }

    /**
     * The basic test To check if json structure is as expected
     *
     * @return  void
     */
    public function test_json_structure(): void
    {
        $user = User::factory()->create();

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertJsonStructure([
            'unlocked_achievements',
            'next_available_achievements',
            'current_badge',
            'next_badge',
            'remaining_to_unlock_next_badge'
        ]);
    }

    /**
     * The basic test to get the achievements of user
     */
    public function test_achievements(): void
    {
        $user = User::factory()->create();

        //Once user is created, default he has no achievements unlocked and hence remaining will be all achievements

        $response = $this->get("/users/{$user->id}/achievements");

        $achievements = Achievement::all();

        $response->assertJsonPath('unlocked_achievements', []);
        $response->assertJsonPath('next_available_achievements', $achievements->pluck('name')->toArray());
    }

    /**
     * The basic test to get the achievements of user
     *
     * @return void
     */
    public function test_adding_achievement(): void
    {
        $user = User::factory()->create();

        //Once user is created, default he has no achievements unlocked and hence remaining will be all achievements
        $lesson = Lesson::first();

        $user->watched()->syncWithoutDetaching([$lesson->id => ['watched' => true]]);

        LessonWatched::dispatch($lesson, $user);

        $response = $this->get("/users/{$user->id}/achievements");

        $achievement = Achievement::where('lessons_watched_count', 1)->first();
        $remaining = Achievement::where('id', '<>', $achievement->id)->get()->pluck('name')->toArray();

        $response->assertJsonPath('unlocked_achievements', [$achievement->name]);
        $response->assertJsonPath('next_available_achievements', $remaining);
    }

    /**
     * The basic test to get the badge of user
     *
     * @return void
     */
    public function test_adding_badge(): void
    {
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
            $comment = Comment::query()->create(['body' => Str::random(), 'user_id' => $user->id]);
            CommentWritten::dispatch($comment);
            $i++;
        }

        $response = $this->get("/users/{$user->id}/achievements");


        // As watching first lesson and 5 lessons are 2 achievements and writing 1 comment and writing 3 comments are other 2 achievements
        // Fetching these 4 achievements and on 4 achievements , an Intermediate badge is unlocked

        // $achievements_unlocked = $user->achievements()->count();   ---  this will be 4
        // $badge = Badge::where('achievements_unlocked_count',$achievements_unlocked)->first(); // This will be Intermediate
        // $badge = $badge->nextBadge;  This will give Master


        $achievements = Achievement::query()->whereIn('lessons_watched_count', [1, 5])->orWhereIn('comments_written_count', [1, 3])->get();
        $remaining = Achievement::all()->diff($achievements);

        $response->assertJsonPath('unlocked_achievements', $achievements->pluck('name')->toArray());
        $response->assertJsonPath('next_available_achievements', $remaining->pluck('name')->toArray());
        $response->assertJsonPath('current_badge', Badges::INTERMEDIATE);
        $response->assertJsonPath('next_badge', Badges::ADVANCED);
    }


}
