<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgesMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badges_master', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedSmallInteger('achievements_unlocked_count')->unique();
            $table->unsignedSmallInteger('badge_order')->nullable();
            $table->foreignId('next_badge_id')->nullable()->unique()->constrained('badges_master');
            $table->foreignId('prev_badge_id')->nullable()->unique()->constrained('badges_master');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('badges_master');
    }
}
