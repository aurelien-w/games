<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duel', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('player_a_id')
                ->foreign('player_a_id')
                ->references('id')
                ->on('players');

            $table->unsignedInteger('player_b_id')
                ->foreign('player_b_id')
                ->references('id')
                ->on('players');

            $table->unsignedInteger('score_a')
                ->default(0);

            $table->unsignedInteger('score_b')
                ->default(0);

            $table->integer('rank_a');

            $table->integer('rank_b');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('duel');
    }
}
