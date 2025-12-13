<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mysql_cms';
    public function up(): void
    {
        // Main corporate profile page
        Schema::create('corprofile_pages', function (Blueprint $table) {
            $table->id();
            $table->string('video')->nullable();
            $table->text('description')->nullable();
            
            // Vision
            $table->string('vision_image')->nullable();
            $table->text('vision_text')->nullable();
            
            // Mission
            $table->string('mission_image')->nullable();
            $table->text('mission_text')->nullable();
            
            // Single images for sections
            $table->string('objectives_image')->nullable();
            $table->string('strategies_image')->nullable();
            $table->string('values_image')->nullable();
            $table->string('principles_image')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->boolean('is_published')->default(false);
            $table->unsignedBigInteger('published_by')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        // Objectives (multiple)
        Schema::create('corprofile_objectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('corprofile_page_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('order')->default(0); 
            $table->timestamps();
        });

        // Strategies (list of text)
        Schema::create('corprofile_strategies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('corprofile_page_id')->constrained()->onDelete('cascade');
            $table->text('text');
            $table->integer('order')->default(0); 
            $table->timestamps();
        });

        // Values (list of text)
        Schema::create('corprofile_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('corprofile_page_id')->constrained()->onDelete('cascade');
            $table->text('text');
            $table->integer('order')->default(0); 
            $table->timestamps();
        });

        // Guiding Principles (list of text)
        Schema::create('corprofile_principles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('corprofile_page_id')->constrained()->onDelete('cascade');
            $table->text('text');
            $table->integer('order')->default(0); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corprofile_principles');
        Schema::dropIfExists('corprofile_values');
        Schema::dropIfExists('corprofile_strategies');
        Schema::dropIfExists('corprofile_objectives');
        Schema::dropIfExists('corprofile_pages');
    }
};