<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Badge
 *
 * @property Badge $nextBadge
 * @property Badge $prevBadge
 *
 * @package App\Models
 */
class Badge extends Model
{
    use HasFactory;

    protected $table = 'badges_master';

    /**
     * The next badge
     *
     * @return BelongsTo
     */
    public function nextBadge(): ?BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'next_badge_id');
    }

    /**
     * The prev badge
     *
     * @return BelongsTo
     */
    public function prevBadge(): ?BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'prev_badge_id');
    }

}
