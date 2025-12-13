<?php

namespace App\Models;
 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_category_id',
        'name',
        'slug',
        'svg',
        'heading',
        'description',
        'order',
        'is_active',
        'subtype',
        'is_approved'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_approved'=> 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class)->orderBy('order');
    }

    public function contents()
    {
        return $this->morphMany(LinkContent::class, 'contentable')->orderBy('order');
    }
    
}