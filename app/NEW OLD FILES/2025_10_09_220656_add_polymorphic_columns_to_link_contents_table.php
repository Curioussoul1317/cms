<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('link_contents', function (Blueprint $table) {
            // Add polymorphic columns
            $table->string('contentable_type')->nullable()->after('id');
            $table->unsignedBigInteger('contentable_id')->nullable()->after('contentable_type');
            
            // Add index for better performance
            $table->index(['contentable_type', 'contentable_id']);
        });
        
        // Migrate existing data - set all existing contents to belong to Links
        DB::table('link_contents')
            ->whereNotNull('link_id')
            ->update([
                'contentable_type' => 'App\\Models\\Link',
                'contentable_id' => DB::raw('link_id')
            ]);
        
        // Now make the columns non-nullable
        Schema::table('link_contents', function (Blueprint $table) {
            $table->string('contentable_type')->nullable(false)->change();
            $table->unsignedBigInteger('contentable_id')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('link_contents', function (Blueprint $table) {
            $table->dropIndex(['contentable_type', 'contentable_id']);
            $table->dropColumn(['contentable_type', 'contentable_id']);
        });
    }
};