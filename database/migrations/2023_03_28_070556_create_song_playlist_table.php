<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSongPlaylistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('song_playlist', function (Blueprint $table) {
            $table->integer('id_song')->unsigned();
            $table->foreign('id_song')->references('id')->on('songs');
            $table->integer('id_playlist')->unsigned();
            $table->foreign('id_playlist')->references('id')->on('playlists');
            $table->primary(['id_song', 'id_playlist']);
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
        Schema::dropIfExists('song_playlist');
    }
}
