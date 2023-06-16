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
            $table->unsignedBigInteger('color_palette_id')->default(1);
            $table->string('phone')->unique();
            $table->boolean('phone_verified')->default(true); // it must be false
            $table->timestamp('phone_verified_at')->default(now()); // it must be nullable
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('color_palette_id')->references('id')->on('settings')->onDelete('cascade');
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
