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
        Schema::create('trainers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subadmin_id');
            $table->unsignedBigInteger('team_leader_id');
            $table->string('name');
            $table->string('designation')->nullable();
            $table->integer('points')->default(0);
            $table->string('phone')->nullable();
            $table->string('dob')->nullable();
            $table->string('blood')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('facebook_link')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('subadmin_id')->references('id')->on('subadmins')->onDelete('cascade');
            $table->foreign('team_leader_id')->references('id')->on('team_leaders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainers');
    }
};
