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
            $table->string('name','45');
            $table->string('store_name');
            $table->foreignId('category_id')->constrained('categories');//$table->bigint('category_id')  $table->foreign('categoey_id)->references('id')->on('categories')->ondelete('cascade');
            $table->string('image_path');
            $table->string('invoice')->nullable;
            $table->decimal('price');
            $table->date('purchase_date')->nullable();
            $table->boolean('verfied');
            $table->timestamps();
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
