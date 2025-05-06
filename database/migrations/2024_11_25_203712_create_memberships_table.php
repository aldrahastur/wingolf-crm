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
        Schema::create('memberships', function (Blueprint $table) {
            $table->ulid('id')->unique();
            $table->string('name');
            $table->string('settlement_period')->nullable();
            $table->float('member_fee')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('membership_user', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('membership_id');
            $table->foreignUlid('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
