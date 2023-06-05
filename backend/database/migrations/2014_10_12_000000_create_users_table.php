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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('color_palette_id');
            $table->unsignedBigInteger('phone_id');
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('color_palette_id')->references('id')->on('settings')->onDelete('cascade');
            $table->foreign('phone_id')->references('id')->on('phones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
