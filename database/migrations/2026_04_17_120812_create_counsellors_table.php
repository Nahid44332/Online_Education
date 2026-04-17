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
        Schema::create('counsellors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subadmin_id');
            $table->string('name');
            $table->string('designation')->nullable();
            $table->integer('points')->default(0);
            $table->string('phone')->nullable();
            $table->string('gender')->nullable(); // নতুন
            $table->text('address')->nullable(); // নতুন
            $table->string('dob')->nullable();
            $table->string('blood')->nullable();
            $table->integer('status')->default(1);
            $table->string('profile_image')->nullable();
            $table->string('facebook_link')->nullable();

            $table->foreign('subadmin_id')->references('id')->on('subadmins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counsellors');
    }
};
