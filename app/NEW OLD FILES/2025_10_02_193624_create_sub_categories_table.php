<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->string('svg')->nullable();
            $table->string('heading');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('subtype');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });

        DB::table('sub_categories')->insert([
            'main_category_id' => 1,  
            'name' => 'HomePage',
            'slug' => 'HomePage',
            'svg' => null,
            'heading' => 'HomePage',
            'description' => 'HomePage',
            'order' => 0,
            'is_active' => true,
            'subtype' => 'Page',  
            'is_approved' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categories');
    }
};
