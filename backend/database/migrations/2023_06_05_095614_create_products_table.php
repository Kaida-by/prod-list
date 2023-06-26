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
            $table->string('count');
            $table->unsignedBigInteger('comment_id')->nullable();
            $table->unsignedBigInteger('type_count_id');
            $table->unsignedBigInteger('type_product_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('type_count_id')->references('id')->on('type_counts')->onDelete('cascade');
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
            $table->foreign('type_product_id')->references('id')->on('type_products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
