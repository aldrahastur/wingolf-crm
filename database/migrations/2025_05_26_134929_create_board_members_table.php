<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('board_members', function (Blueprint $table) {
            $table->ulid('id');
            $table->foreignUlid('membership_id');
            $table->foreignUlid('user_id');
            $table->string('position');
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->timestamps();

            $table->unique(['membership_id', 'position']);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('board_members');
    }
};
