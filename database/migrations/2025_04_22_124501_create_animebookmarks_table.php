<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimeBookmarksTable extends Migration
{
    public function up()
    {
        Schema::create('anime_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('anime_id');
            $table->string('title');
            $table->string('image_url');
            $table->boolean('is_finished')->default(false);
            $table->boolean('is_favorite')->default(false);
$table->enum('status', ['wishlist'])->default('wishlist');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('anime_bookmarks');
    }
}
