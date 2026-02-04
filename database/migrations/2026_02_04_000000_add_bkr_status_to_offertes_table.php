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
        Schema::table('offertes', function (Blueprint $table) {
            $table->enum('bkr_status', ['unknown', 'approved', 'denied'])->default('unknown')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offertes', function (Blueprint $table) {
            $table->dropColumn('bkr_status');
        });
    }
};
