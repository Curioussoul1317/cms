<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodDirector extends Model
{
    use HasFactory;
    protected $connection = 'mysql_cms';
    protected $table = 'bod_directors';
        protected $fillable = [
        'name',
        'title',
        'image',
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

// Relationships
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

    // Scope for active directors
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for ordered directors
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}