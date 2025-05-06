<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('membership_user', function (Blueprint $table) {
            $table->date('membership_admission_date')->nullable();
            $table->date('membership_leave_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->dropColumn('membership_admission_date');
            $table->dropColumn('membership_leave_date');
        });
    }
};
