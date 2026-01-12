<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->date('birthday')->nullable();
            $table->string('avatar')->nullable();

            $table->string('job_title')->nullable(); // VD: General Manager, Sale Leader
            $table->string('status')->default('active')->index(); // active, inactive, banned

            $table->string('password');


            $table->text('refresh_token')->nullable();

            $table->rememberToken();

            // --- TIMESTAMPS ---
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
