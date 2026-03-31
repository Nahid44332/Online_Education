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
        Schema::create('teacher_applications', function (Blueprint $table) {
            $table->id();
             $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('address')->nullable();
            $table->string('qualification');
            $table->text('skills')->nullable();
            $table->integer('experience')->default(0);
            $table->string('cv')->nullable(); // file path
            $table->string('image'); // image path
            $table->text('cover_letter')->nullable();
            $table->string('application_id')->unique()->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_applications');
    }
};
