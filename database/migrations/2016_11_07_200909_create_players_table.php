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
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('name')->index('name');
            $table->string('position');
            $table->tinyInteger('number')->unsigned()->nullable();
            $table->integer('team_id')->nullable();
            $table->tinyInteger('age')->unsigned()->nullable();
            $table->smallInteger('weight')->unsigned();
            $table->string('height');
            $table->string('birthplace');
            $table->string('birthdate');
            $table->timestamps();

            $table->primary('id');
            $table->foreign('team_id')->references('id')->on('teams')->onUpdate('cascade')->onDelete('set null');
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
