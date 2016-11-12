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
            $table->smallInteger('goals')->unsigned();
            $table->smallInteger('assists')->unsigned();
            $table->smallInteger('games_played')->unsigned();
            $table->smallInteger('gwg')->unsigned();
            $table->smallInteger('plus_minus');
            $table->smallInteger('pp_goals')->unsigned();
            $table->smallInteger('pp_assists')->unsigned();
            $table->smallInteger('sh_goals')->unsigned();
            $table->smallInteger('sh_assists')->unsigned();
            $table->smallInteger('shots')->unsigned();
            $table->smallInteger('penalty_mins')->unsigned();
            $table->decimal('points_per_game', 6, 4);
            $table->decimal('toi_per_game', 10, 4);
            $table->decimal('shifts_per_game', 8, 4);
            $table->decimal('shoot_pct', 6, 4);
            $table->decimal('faceoff_pct', 6, 4);
            $table->timestamps();

            $table->foreign('player_id')->references('id')->on('players')->onUpdate('cascade')->onDelete('cascade');
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
