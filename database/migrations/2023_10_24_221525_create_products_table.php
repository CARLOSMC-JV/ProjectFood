<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->text('description')->nullable();

            $table->float('price');

            $table->unsignedBigInteger('class_categories_id');
            $table->foreign('class_categories_id')->references('id')->on('class_categories');
            $table->string('image');

            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('set null');

            $table->unsignedBigInteger('category_id')->nullable(); 
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null'); 

            // $table->unsignedBigInteger('brand_id');
            // $table->foreign('brand_id')->references('id')->on('brands');

            $table->integer('quantity');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');

        Schema::dropIfExists('products');
    }
};
