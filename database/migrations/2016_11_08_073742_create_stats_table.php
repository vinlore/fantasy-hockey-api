<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('player_id')->unsigned()->index('player_id');
            $table->string('years');
            $table->smallInteger('goals')->unsigned()->default(0);
            $table->smallInteger('assists')->unsigned()->default(0);
            $table->smallInteger('games_played')->unsigned()->default(0);
            $table->smallInteger('gwg')->unsigned()->nullable();
            $table->smallInteger('plus_minus')->nullable();
            $table->smallInteger('pp_goals')->unsigned()->nullable();
            $table->smallInteger('pp_assists')->unsigned()->nullable();
            $table->smallInteger('sh_goals')->unsigned()->nullable();
            $table->smallInteger('sh_assists')->unsigned()->nullable();
            $table->smallInteger('shots')->unsigned()->nullable();
            $table->smallInteger('penalty_mins')->unsigned()->default(0);
            $table->smallInteger('blocked_shots')->unsigned()->nullable();
            $table->smallInteger('hits')->unsigned()->nullable();
            $table->smallInteger('takeaways')->unsigned()->nullable();
            $table->smallInteger('faceoffs_won')->unsigned()->nullable();
            $table->smallInteger('faceoffs_lost')->unsigned()->nullable();
            $table->decimal('shots_per_game', 4, 2)->nullable();
            $table->decimal('points_per_game', 6, 4)->nullable();
            $table->decimal('toi_per_game', 10, 4)->nullable();
            $table->decimal('shifts_per_game', 8, 4)->nullable();
            $table->decimal('shoot_pct', 6, 4)->nullable();
            $table->decimal('faceoff_pct', 6, 4)->nullable();

            // Goalie Stats
            $table->smallInteger('games_started')->unsigned()->nullable();
            $table->smallInteger('goals_against')->unsigned()->nullable();
            $table->decimal('gaa', 6, 4)->unsigned()->nullable();
            $table->smallInteger('losses')->unsigned()->nullable();
            $table->smallInteger('ot_losses')->unsigned()->nullable();
            $table->decimal('save_pct', 6, 4)->unsigned()->nullable();
            $table->integer('saves')->unsigned()->nullable();
            $table->integer('shots_against')->unsigned()->nullable();
            $table->smallInteger('shutouts')->unsigned()->nullable();
            $table->smallInteger('wins')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('player_id')->references('id')->on('players')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stats');
    }
}
