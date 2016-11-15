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
            $table->string('shoots');
            $table->tinyInteger('number')->unsigned()->nullable();
            $table->integer('team_id')->nullable();
            $table->tinyInteger('age')->unsigned()->nullable();
            $table->smallInteger('weight')->unsigned()->nullable();
            $table->string('height')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('birthdate')->nullable();
            $table->integer('draft_year')->nullable();
            $table->integer('draft_no')->nullable();
            $table->integer('draft_round')->nullable();
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
