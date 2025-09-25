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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('client_name')->nullable();
            $table->string('project_url')->nullable();
            $table->string('featured_image');
            $table->json('gallery_images')->nullable();
            $table->json('technologies_used')->nullable();
            $table->enum('category', ['web_development', 'mobile_app', 'web_app', 'ecommerce', 'other']);
            $table->date('completed_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
