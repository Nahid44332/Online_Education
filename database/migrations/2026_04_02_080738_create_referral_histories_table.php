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
        Schema::create('referral_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id'); // যে student points পেয়েছে
            $table->unsignedBigInteger('referred_student_id'); // যে student active হয়েছে
            $table->integer('points')->default(0); // reward points
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('referred_student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_histories');
    }
};
