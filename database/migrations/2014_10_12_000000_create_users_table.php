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
            $table->char('uuid',36);
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->tinyInteger('is_admin')->default(0);
            $table->string('email', 255)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->char('avatar',36)->nullable();
            $table->string('address',255);
            $table->string('phone_number',255);
            $table->tinyInteger('is_marketing')->default(0);
            $table->timestamps();
            $table->timestamp('last_login_at')->nullable();
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
