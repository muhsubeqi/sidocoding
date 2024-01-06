<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            // Relasi Category
            $table->unsignedBigInteger('product_categories_id')->nullable();
            $table->foreign('product_categories_id')->on('product_categories')->references('id')
                ->onUpdate('cascade')->onDelete('set null');
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->string('file')->nullable();
            $table->float('price');
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
        Schema::dropIfExists('products');
    }
}