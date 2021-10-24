<?php

namespace Database\Seeders\Master;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

/**
 * Class AchievementSeeder
 *
 * Master data for achievements, in case of any new achievements, we can add here and seed new data,
 * or we can have an admin panel to add these master data .
 *
 * Assuming name to be description for now.
 * Lesson and comment count for attached to user will be basis of unlocking the achievements
 *
 * @package Database\Master\Seeders
 */
class AchievementSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function run()
    {

        $achievements = [
            [
                'name' => 'First Lesson Watched',
                'lessons_count' => 1
            ],
            [
                'name' => '5 Lessons Watched',
                'lessons_count' => 5
            ],
            [
                'name' => '10 Lessons Watched',
                'lessons_count' => 10
            ],
            [
                'name' => '25 Lessons Watched',
                'lessons_count' => 25
            ],
            [
                'name' => '50 Lessons Watched',
                'lessons_count' => 50
            ],
            [
                'name' => 'First Comment Written',
                'comments_count' => 1
            ],
            [
                'name' => '3 Comments Written',
                'comments_count' => 3
            ],
            [
                'name' => '5 Comments Written',
                'comments_count' => 5
            ],
            [
                'name' => '10 Comments Written',
                'comments_count' => 10
            ],
            [
                'name' => '20 Comments Written',
                'comments_count' => 20
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::updateOrCreate(
                [
                    'name' => $achievement['name']
                ],
                [
                    'description' => $achievement['name'],
                    'lessons_watched_count' => $achievement['lessons_count'] ?? null,
                    'comments_written_count' => $achievement['comments_count'] ?? null,
                ]
            );
        }
    }
}
