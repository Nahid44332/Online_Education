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
        Schema::create('helplines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subadmin_id'); // subadmins টেবিলের সাথে রিলেশন
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('address')->nullable();
            $table->string('blood')->nullable();
            $table->enum('shift', ['day', 'night', 'full'])->default('day');
            $table->boolean('is_online')->default(0);
            $table->string('meet_link')->nullable();
            $table->timestamps();

            $table->foreign('subadmin_id')->references('id')->on('subadmins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('helplines');
    }
};
