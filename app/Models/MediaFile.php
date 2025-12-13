<?php

namespace App\Models;
 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaFile extends Model
{
    use HasFactory;
    protected $connection = 'mysql_cms';
    protected $table = 'mediafiles';

    protected $fillable = [
        'mediacategory_id',
        'title',
        'date',
        'reference_number',
        'file_path',
        'file_name',
        'file_size',
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
        'date' => 'date',
        'is_active' => 'boolean',
        'is_approved' => 'boolean',
        'is_published' => 'boolean',
        'approved_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    // Relationship
    public function category()
    {
        return $this->belongsTo(MediaCategory::class, 'mediacategory_id');
    }

    // Accessors
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }

    public function getFileSizeFormattedAttribute()
    {
        if ($this->file_size) {
            if ($this->file_size < 1024) {
                return $this->file_size . ' KB';
            }
            return round($this->file_size / 1024, 2) . ' MB';
        }
        return 'Unknown';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('date', 'desc');
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