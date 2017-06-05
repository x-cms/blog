<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->string('title')->unique();
            $table->string('slug');
            $table->string('thumbnail')->nullable();
            $table->string('description')->nullable();
            $table->text('content_markdown')->nullable();
            $table->text('content_html')->nullable();
            $table->tinyInteger('status')->unsigned()->default(1);
            $table->integer('order')->unsigned()->default(0);
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('posts');
    }
}
