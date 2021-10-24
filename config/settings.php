<?php

use App\Dictionaries\Badges;

return [

    'badges_info' => [
        Badges::BEGINNER => [
            'description' => Badges::BEGINNER,
            'achievement_count' => 0,
            'order' => 1,
            'prev' => null
        ],
        Badges::INTERMEDIATE => [
            'description' => Badges::INTERMEDIATE,
            'achievement_count' => 4,
            'order' => 2,
            'prev' => Badges::BEGINNER
        ],
        Badges::ADVANCED => [
            'description' => Badges::ADVANCED,
            'achievement_count' => 8,
            'order' => 3,
            'prev' => Badges::INTERMEDIATE
        ],
        Badges::MASTER => [
            'description' => Badges::MASTER,
            'achievement_count' => 10,
            'order' => 4,
            'prev' => Badges::ADVANCED
        ],
    ],

];
