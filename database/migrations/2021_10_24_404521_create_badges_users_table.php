<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badges_users', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('badge_id')->constrained('badges_master');
            $table->boolean('is_current')->default(true);
            $table->foreignId('achievement_id')->nullable()->constrained('achievements_master');
            $table->dateTime('date');
            $table->unique(['user_id', 'badge_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('badges_users');
    }
}
