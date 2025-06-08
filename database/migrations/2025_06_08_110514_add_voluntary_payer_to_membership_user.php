<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('membership_user', function (Blueprint $table) {
            $table->tinyInteger('voluntary_payer')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('member_user', function (Blueprint $table) {
            //
        });
    }
};
