<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomTeamUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_team_user', function (Blueprint $table) {
            $table->integer('custom_team_id')->unsigned();
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->timestamps();

            $table->primary(['custom_team_id', 'user_id']);
            $table->foreign('custom_team_id')->references('id')->on('custom_teams')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_team_user');
    }
}
