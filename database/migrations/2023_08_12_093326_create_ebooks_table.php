<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebooks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            // Relasi Category
            $table->unsignedBigInteger('categories_id')->nullable();
            $table->foreign('categories_id')->on('categories')->references('id')
                ->onUpdate('cascade')->onDelete('set null');
            $table->string('cover')->nullable();
            $table->string('file')->nullable();
            $table->string('path')->nullable();
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
        Schema::dropIfExists('ebooks');
    }
}