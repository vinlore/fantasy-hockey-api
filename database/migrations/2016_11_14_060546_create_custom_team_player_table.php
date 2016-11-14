<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomTeamPlayerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_team_player', function (Blueprint $table) {
            $table->integer('custom_team_id')->unsigned();
            $table->integer('player_id')->unsigned()->index('player_id');
            $table->timestamps();

            $table->primary(['custom_team_id', 'player_id']);
            $table->foreign('custom_team_id')->references('id')->on('custom_teams')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('custom_team_player');
    }
}
