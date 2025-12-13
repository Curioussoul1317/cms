<?php

namespace App\Models;
 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeroSection extends Model
{
    use HasFactory;
   
    protected $table = 'hero_sections';
    protected $connection = 'mysql_cms';
    protected $fillable = [
        'route_name',
        'section',
        'title',
        'subtitle',
        'button_text',
        'button_link',
        'image',
        'background_color',
        'is_active',
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
        'is_active' => 'boolean',
        'is_approved' => 'boolean',
        'is_published' => 'boolean',
        'approved_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    /**
     * Get the full identifier for this hero section
     */
    public function getIdentifierAttribute(): string
    {
        return $this->section 
            ? "{$this->route_name}:{$this->section}" 
            : $this->route_name;
    }

    /**
     * Delete associated image when hero is deleted
     */
    protected static function booted(): void
    {
        static::deleting(function (HeroSection $hero) {
            if ($hero->image && Storage::disk('public')->exists($hero->image)) {
                Storage::disk('public')->delete($hero->image);
            }
        });
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