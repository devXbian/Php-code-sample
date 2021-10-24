<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Database\Seeders\Master\AchievementSeeder;
use Database\Seeders\Master\BadgeSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $lessons = Lesson::factory()
            ->count(20)
            ->create();

        $this->call([
            BadgeSeeder::class,
            AchievementSeeder::class
        ]);
    }
}
