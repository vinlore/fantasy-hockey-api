<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->integer('id')->unsigned()->index('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('name')->index('name');
            $table->string('position');
            $table->tinyInteger('number')->unsigned()->nullable();
            $table->string('team_abbr');
            $table->string('team_name');
            $table->tinyInteger('age')->unsigned();
            $table->smallInteger('weight')->unsigned();
            $table->string('height');
            $table->string('birthplace');
            $table->timestamps();

            $table->foreign('team_abbr')->references('team_abbr')->on('teams')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
}
