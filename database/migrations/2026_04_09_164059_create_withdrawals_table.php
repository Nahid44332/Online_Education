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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id'); // কোন টিচার টাকা চাচ্ছেন
            $table->integer('team_leader_id')->nullable();
            $table->integer('amount'); // কত পয়েন্ট/টাকা
            $table->string('method'); // বিকাশ, নগদ নাকি ব্যাংক
            $table->string('account_details'); // ফোন নাম্বার বা একাউন্ট নাম্বার
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
