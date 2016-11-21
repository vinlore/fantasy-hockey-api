<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->integer('id');
            $table->string('team_abbr')->unique();
            $table->string('name');
            $table->string('division');
            $table->string('conference');
            $table->integer('goals_against')->unsigned()->nullable();
            $table->integer('goals_for')->unsigned()->nullable();
            $table->smallInteger('points')->unsigned()->nullable();
            $table->tinyInteger('division_rank')->unsigned()->nullable();
            $table->tinyInteger('conference_rank')->unsigned()->nullable();
            $table->tinyInteger('league_rank')->unsigned()->nullable();
            $table->tinyInteger('wins')->unsigned()->nullable();
            $table->tinyInteger('losses')->unsigned()->nullable();
            $table->tinyInteger('ot_losses')->unsigned()->nullable();
            $table->tinyInteger('games_played')->unsigned()->nullable();
            $table->string('streak')->nullable();
            $table->string('home_record')->nullable();
            $table->string('away_record')->nullable();
            $table->string('last_ten_record')->nullable();
            $table->string('central_record')->nullable();
            $table->string('pacific_record')->nullable();
            $table->string('atlantic_record')->nullable();
            $table->string('east_record')->nullable();
            $table->string('west_record')->nullable();
            $table->timestamps();

            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
