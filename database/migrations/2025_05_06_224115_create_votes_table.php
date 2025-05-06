<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUuid('poll_option_id');
            $table->foreignUuid('participant_id')->nullable();
            $table->foreignUuid('user_id')->nullable();
            $table->enum('choices', ['yes', 'maybe', 'no']);
            $table->timestamps();

            $table->unique(['poll_option_id', 'participant_id']);
            $table->unique(['poll_option_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
