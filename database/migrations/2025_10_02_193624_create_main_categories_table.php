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
    protected $connection = 'mysql_cms';
    public function up(): void
    {
        Schema::create('main_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('order')->default(0);
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
        DB::table('main_categories')->insert([
            'name' => 'HomePage',
            'slug' => 'HomePage',
            'order' => 0,
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
        Schema::dropIfExists('main_categories');
    }
};
