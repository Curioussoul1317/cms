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
        Schema::create('link_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('template_name'); // e.g., 'cards', 'hero', 'gallery'
            $table->json('data'); // All template data stored as JSON
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link_contents');
    }
};
