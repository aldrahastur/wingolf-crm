<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rental_contracts', function (Blueprint $table) {
            $table->ulid('id');
            $table->foreignUlid('room_id');
            $table->foreignUlid('user_id');
            $table->foreignUlid('team_id');
            $table->date('started_at');
            $table->date('ended_at')->nullable();
            $table->string('rental_contract_pdf')->nullable();
            $table->string('tenant_certificate_pdf')->nullable();
            $table->float('rental_price');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_contracts');
    }
};
