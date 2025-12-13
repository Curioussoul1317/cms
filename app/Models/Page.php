<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $connection = 'mysql_cms';
    protected $table = 'pages';
    protected $fillable = [
        'main_category_id',  
        'parent_id',
        'name',
        'slug',
        'heading',
        'description',
        'order', 
        'has_children',  
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
        'has_children'  => 'boolean',  
        'is_approved' => 'boolean',
        'is_published' => 'boolean',
        'approved_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    
    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class);
    }

   
    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

   
    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id')->orderBy('order');
    }
 
    public function descendants()
    {
        return $this->children()->with('descendants');
    }
 
    public function contents()
    {
        return $this->hasMany(PageContent::class)->orderBy('order');
    }
 
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    
    public function scopeByMainCategory($query, $mainCategoryId)
    {
        return $query->where('main_category_id', $mainCategoryId);
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