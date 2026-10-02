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
        Schema::create('freelancers', function (Blueprint $table) {
            $table->foreignId('user_id')
            ->primary()
            ->constrained('users')
            ->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('title')->nullable();
            $table->string('profile_photo_path')->nullable();
            $table->string('country')->default('eg');
            $table->enum('gender',['male','female'])->nullable();
            $table->date('birthday')->nullable();
            $table->boolean('verified')->default(0);
            $table->text('description')->nullable();
            $table->float('hourly_rate')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancers');
    }
};
