<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Comment;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('content');
            $table->unsignedInteger('creator_id')->nullable();
            $table->unsignedInteger('article_id')->nullable();
            $table->smallInteger('status')->default(Comment::STATUS_ALIVE);
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
