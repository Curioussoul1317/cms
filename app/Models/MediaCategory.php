<?php

namespace App\Models;
 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MediaCategory extends Model
{
    use HasFactory;
    protected $connection = 'mysql_cms';
    protected $table = 'mediacategories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'order',
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

    // Relationship
    public function mediaFiles()
    {
        return $this->hasMany(MediaFile::class, 'mediacategory_id');
    }

    public function activeMediaFiles()
    {
        return $this->hasMany(MediaFile::class, 'mediacategory_id')->where('is_active', true);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
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