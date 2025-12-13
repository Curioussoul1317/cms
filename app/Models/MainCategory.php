<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    use HasFactory;
    protected $connection = 'mysql_cms';
    protected $table = 'main_categories';
    protected $fillable = [
        'name',
        'slug',
        'order',  
        'created_by',
        'updated_by',
        'is_approved',
        'approved_by',
        'approved_at',
        'is_published',
        'published_by',
        'published_at',
        
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    'is_published' => 'boolean',
    'approved_at' => 'datetime',
    'published_at' => 'datetime', 
    ];

   
    public function pages()
    {
        return $this->hasMany(Page::class)->orderBy('order');
    }
 
    public function topLevelPages()
    {
        return $this->hasMany(Page::class)->whereNull('parent_id')->orderBy('order');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->on('mysql');
    }
    
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by')->on('mysql');
    }
    
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by')->on('mysql');
    }
    
    public function publishedBy()
    {
        return $this->belongsTo(User::class, 'published_by')->on('mysql');
    }
}