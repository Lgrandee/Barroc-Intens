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
        Schema::create('planning_tickets', function (Blueprint $table) {
            $table->id();
            $table->enum('catagory', ['meeting', 'installation', 'service']);
            $table->foreignId('feedback_id')->nullable()->constrained('feedbacks')->onDelete('set null');
            $table->string('location');
            $table->dateTime('scheduled_time')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['open', 'voltooid', 'probleem', 'te_laat'])->default('open');
            $table->enum('priority', ['laag', 'medium', 'hoog'])->nullable();
            $table->text('used_materials')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planning_tickets');
    }
};
