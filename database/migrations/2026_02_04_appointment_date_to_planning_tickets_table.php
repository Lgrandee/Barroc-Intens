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
        Schema::table('planning_tickets', function (Blueprint $table) {
            $table->date('appointment_date')->nullable()->after('scheduled_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('planning_tickets', function (Blueprint $table) {
            $table->dropColumn('appointment_date');
        });
    }
};