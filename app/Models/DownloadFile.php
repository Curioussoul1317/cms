<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class DownloadFile extends Model
{
    use HasFactory;
    protected $connection = 'mysql_cms';
    protected $table = 'downloadfiles';

    protected $fillable = [
        'downloadcategory_id',
        'title',
        'date',
        'eng_file',
        'dhivehi_file',
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

    // Relationships
    public function category()
    {
        return $this->belongsTo(DownloadCategory::class, 'downloadcategory_id');
    }

 

    // Accessors
    public function getEngFileUrlAttribute()
    {
        if ($this->eng_file) {
            return asset('storage/' . $this->eng_file);
        }
        return null;
    }

    public function getDhivehiFileUrlAttribute()
    {
        if ($this->dhivehi_file) {
            return asset('storage/' . $this->dhivehi_file);
        }
        return null;
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