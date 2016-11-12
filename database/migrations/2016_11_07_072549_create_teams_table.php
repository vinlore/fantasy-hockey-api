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
            $table->integer('divisionId');
            $table->string('division');
            $table->integer('conferenceId');
            $table->string('conference');
            $table->timestamps();

            $table->primary(['id', 'team_abbr']);
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
