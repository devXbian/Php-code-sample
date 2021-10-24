<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchievementsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievements_users', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('achievement_id')->constrained('achievements_master');
            $table->dateTime('date');
            $table->foreignId('lesson_id')->nullable()->constrained();
            $table->foreignId('comment_id')->nullable()->constrained();

             });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('achievements_users');
    }
}
