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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('quotation_request_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('status', ['planning', 'in_progress', 'review', 'completed', 'on_hold', 'cancelled'])->default('planning');
            $table->decimal('budget', 10, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('expected_completion')->nullable();
            $table->date('actual_completion')->nullable();
            $table->integer('progress_percentage')->default(0);
            $table->json('milestones')->nullable();
            $table->json('deliverables')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
