<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorprofilePage extends Model
{
    use HasFactory;
    protected $connection = 'mysql_cms';
    protected $table = 'corprofile_pages';
    protected $fillable = [
        'video',
        'description',
        'vision_image',
        'vision_text',
        'mission_image',
        'mission_text',
        'objectives_image',
        'strategies_image',
        'values_image',
        'principles_image',
        'created_by',
        'updated_by',
        'is_active',
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


    public function objectives()
    {
        return $this->hasMany(CorprofileObjective::class)->orderBy('order');
    }

    public function strategies()
    {
        return $this->hasMany(CorprofileStrategy::class)->orderBy('order');
    }

    public function values()
    {
        return $this->hasMany(CorprofileValue::class)->orderBy('order');
    }

    public function principles()
    {
        return $this->hasMany(CorprofilePrinciple::class)->orderBy('order');
    }
}