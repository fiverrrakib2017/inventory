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
            $table->string('title');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('category_id');

        
            $table->double('p_price', 10,2)->nullable();
            $table->double('s_price', 10,2)->nullable();
            $table->string('product_type');

            $table->string('size')->nullable();
            $table->string('color')->nullable();

            $table->enum('track_qty', ['Yes', 'No'])->default('Yes');
            $table->integer('qty')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();

            $table->foreign('category_id')->on('product__categories')->references('id')->onDelete('cascade');
            $table->foreign('brand_id')->on('product__brands')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
