<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $connection = 'mysql_cms';
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('pages')->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->string('svg')->nullable();
            $table->string('heading')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);   
            $table->boolean('has_children')->default(false);
            $table->string('subtype')->nullable(); 
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->boolean('is_published')->default(false);
            $table->unsignedBigInteger('published_by')->nullable();
            $table->timestamp('published_at')->nullable(); 
            $table->timestamps();
            
            $table->index('main_category_id');
            $table->index('parent_id');
            $table->index('slug');
        });
        
        DB::table('pages')->insert([
            'main_category_id' => 1,  
            'parent_id' => null,
            'name' => 'Home',
            'slug' => 'home',
            'heading' => 'Welcome to Our Website',
            'description' => 'Main homepage content',
            'order' => 0, 
            'has_children' => false, 
            'created_by'=> null, 
            'updated_by'=> null, 
            'is_approved' => false,
            'approved_by'=> null, 
            'approved_at'=> now(),
            'is_published' => false,
            'published_by'=> null, 
            'published_at'=> now(),  
           
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
