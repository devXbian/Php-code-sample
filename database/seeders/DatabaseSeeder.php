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

        //SEEDING MASTER DATA
        $this->call([
            BadgeSeeder::class,
            AchievementSeeder::class
        ]);

        //SEEDING FAKER DATA
        Lesson::factory()
            ->count(20)
            ->create();

        Comment::factory()->count(2)->create();

    }
}
