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
        Schema::create('rooms', function (Blueprint $table) {
            $table->ulid('id');
            $table->foreignUlid('team_id');
            $table->foreignUlid('user_id')->nullable();
            $table->string('name');
            $table->string('house_number')->nullable();
            $table->string('floor')->nullable();
            $table->string('room_number')->nullable();
            $table->string('description')->nullable();
            $table->float('rental_price')->nullable();
            $table->float('security_deposit')->nullable();
            $table->float('room_size')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
