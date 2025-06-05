<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->dateTime('date')->after('title')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('meeting', function (Blueprint $table) {
            //
        });
    }
};
