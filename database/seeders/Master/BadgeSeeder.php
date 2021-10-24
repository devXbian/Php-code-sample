<?php

namespace Database\Seeders\Master;

use App\Dictionaries\Badges;
use App\Models\Badge;
use Illuminate\Database\Seeder;

/**
 * Class BadgeSeeder
 *
 * Master data for badges, in case of any new badges, we can add in settings config and in dictionary as of now to make it configurable and seed new data,
 * or we can have an admin panel to add these master data (In this case, the settings config and dictionary won't be coming in use)
 *
 * Assuming name to be description for now.
 *
 * Achievement unlocked count to be stored for badges to be allocated
 *
 * @package Database\Seeders\Master
 */
class BadgeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function run()
    {

        $badges = Badges::getValues();
        foreach ($badges as $badge) {
            $badgeInfo = config('settings.badges_info.' . $badge);
            if (!empty($badgeInfo)) {

                $badge = Badge::updateOrCreate(
                    [
                        'name' => $badge
                    ],
                    [
                        'description' => $badgeInfo['description'],
                        'achievements_unlocked_count' => $badgeInfo['achievement_count'],
                        'badge_order' => $badgeInfo['order'],

                    ]
                );

                $prevBadge = Badge::where('name', $badgeInfo['prev'])->first();

                if ($prevBadge) {
                    $prevBadge->next_badge_id = $badge->id;
                    $prevBadge->save();
                }

            }
        }


    }
}
