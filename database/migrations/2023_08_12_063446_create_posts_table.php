<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->longText('content')->nullable();
             // Relasi Category
            $table->unsignedBigInteger('categories_id')->nullable();
            $table->foreign('categories_id')->on('categories')->references('id')
                ->onUpdate('cascade')->onDelete('set null');
            $table->string('image')->nullable();
            $table->longText('tags')->nullable();
            $table->string('status');
            $table->foreignId('users_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
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